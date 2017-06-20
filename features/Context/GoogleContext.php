<?php
namespace Sil\IdpPw\PasswordStore\Google\Behat\Context;

use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Sil\IdpPw\Common\PasswordStore\PasswordStoreInterface;
use Sil\IdpPw\PasswordStore\Google\Google as GooglePasswordStore;
use Sil\PhpEnv\Env;

class GoogleContext implements Context
{
    /** @var PasswordStoreInterface */
    protected $googlePasswordStore;
    
    /**
     * @Given I can make authenticated calls to Google
     */
    public function iCanMakeAuthenticatedCallsToGoogle()
    {
        $this->googlePasswordStore = new GooglePasswordStore(
            Env::getArrayFromPrefix('TEST_GOOGLE_PWSTORE_CONFIG_')
        );
    }

    /**
     * @When I ask Google for a specific user's metadata
     */
    public function iAskGoogleForASpecificUsersMetadata()
    {
        throw new PendingException();
    }

    /**
     * @Then I should get back metadata about that user's password
     */
    public function iShouldGetBackMetadataAboutThatUsersPassword()
    {
        throw new PendingException();
    }
}
