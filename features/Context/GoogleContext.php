<?php
namespace Sil\IdpPw\PasswordStore\Google\Behat\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Exception;
use PHPUnit\Framework\Assert;
use Sil\IdpPw\Common\PasswordStore\PasswordStoreInterface;
use Sil\IdpPw\Common\PasswordStore\UserPasswordMeta;
use Sil\IdpPw\PasswordStore\Google\Behat\DummyUser;
use Sil\IdpPw\PasswordStore\Google\Google as GooglePasswordStore;
use Sil\PhpEnv\Env;

class GoogleContext implements Context
{
    /** @var Exception|null */
    protected $exceptionThrown = null;
    
    /** @var PasswordStoreInterface */
    protected $googlePasswordStore;
    
    /** @var UserPasswordMeta */
    protected $userPasswordMeta;
    
    public function __construct()
    {
        require_once __DIR__ . '/../../vendor/yiisoft/yii2/Yii.php';
    }
    
    /**
     * @Given I can make authenticated calls to Google
     */
    public function iCanMakeAuthenticatedCallsToGoogle()
    {
        $this->googlePasswordStore = new GooglePasswordStore(array_merge(
            [
                'userActiveRecordClass' => DummyUser::class,
            ],
            Env::getArrayFromPrefix('TEST_GOOGLE_PWSTORE_CONFIG_')
        ));
    }

    /**
     * @When I try to get a specific user's metadata
     */
    public function iTryToGetASpecificUsersMetadata()
    {
        try {
            $this->userPasswordMeta = $this->googlePasswordStore->getMeta(12345);
        } catch (Exception $e) {
            $this->exceptionThrown = $e;
        }
    }

    /**
     * @Then I should get back metadata about that user's password
     */
    public function iShouldGetBackMetadataAboutThatUsersPassword()
    {
        Assert::assertInstanceOf(UserPasswordMeta::class, $this->userPasswordMeta);
    }

    /**
     * @Then an exception should not have been thrown
     */
    public function anExceptionShouldNotHaveBeenThrown()
    {
        Assert::assertNull($this->exceptionThrown);
    }

    /**
     * @When I try to set a specific user's password
     */
    public function iTryToSetASpecificUsersPassword()
    {
        try {
            $this->userPasswordMeta = $this->googlePasswordStore->set(
                12345,
                Env::requireEnv('TEST_GOOGLE_USER_NEW_PASSWORD')
            );
        } catch (Exception $e) {
            $this->exceptionThrown = $e;
        }
    }
}
