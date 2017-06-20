<?php
namespace Sil\IdpPw\PasswordStore\Google;

use Google_Client;
use Google_Service_Directory;
use Sil\IdpPw\Common\PasswordStore\AccountLockedException;
use Sil\IdpPw\Common\PasswordStore\PasswordStoreInterface;
use Sil\IdpPw\Common\PasswordStore\UserNotFoundException;
use Sil\IdpPw\Common\PasswordStore\UserPasswordMeta;
use yii\base\Component;

class Google extends Component implements PasswordStoreInterface
{
    public $applicationName = null;
    public $jsonAuthFilePath = null;
    
    private $googleClient = null;
    
    public function init()
    {
        if ( ! empty($this->jsonAuthFilePath)) {
            if ( ! file_exists($this->jsonAuthFilePath)) {
                throw new InvalidArgumentException(sprintf(
                    'JSON auth file path of %s provided, but no such file exists.',
                    var_export($this->jsonAuthFilePath, true)
                ), 1497897359);
            }
        }
        $requiredProperties = [
            'applicationName',
            'jsonAuthFilePath',
        ];
        foreach ($requiredProperties as $requiredProperty) {
            if (empty($requiredProperty)) {
                throw new \InvalidArgumentException(sprintf(
                    'You must provide a value for %s (found %s).',
                    $requiredProperty,
                    var_export($this->$requiredProperty, true)
                ), 1497896922);
            }
        }
        
        parent::init();
    }
    
    protected function getClient()
    {
        if ($this->googleClient === null) {
            $jsonAuthString = \file_get_contents($this->jsonAuthFilePath);
            $authConfig = Json::decode($jsonAuthString);
            
            $googleClient = new Google_Client();
            $googleClient->setApplicationName($this->applicationName);
            $googleClient->addScope(
                Google_Service_Directory::ADMIN_DIRECTORY_USER
            );
            $googleClient->setAuthConfig($authConfig);
            $googleClient->setAccessType('offline');
            
            $this->googleClient = $googleClient;
        }
        return $this->googleClient;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getMeta($employeeId): UserPasswordMeta
    {
        $user = $this->getUser($employeeId);
        if ( ! empty($user)) {
            
            
            // ...
            
            
        }
    }
    
    protected function getUser($employeeId)
    {
        try {
            $directory = new Google_Service_Directory($this->getClient());
            return $directory->users->get($employeeId);
        } catch (Exception $e){
            if ($e->getCode() == 404) {
                throw new UserNotFoundException();
            }
            throw $e;
        }
    }
    
    /**
     * {@inheritdoc}
     */
    public function set($employeeId, $password): UserPasswordMeta
    {
        
    }
}
