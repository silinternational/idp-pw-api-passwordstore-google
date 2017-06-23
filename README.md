# idp-pw-api-passwordstore-google
 Password store component for IdP PW API that uses Google as the backend.

## To Use

1. Create a project on <https://console.developers.google.com/>.
2. Still in the Google Developers Console, create a Service Account.
3. Check "Furnish a new private key" and "Enable G Suite Domain-wide Delegation".
4. Save the JSON file it provides (containing your private key), but **DO NOT**
   store it in public version control (such as in a public GitHub repo).
5. Enable the "Admin SDK" API for your project in the Google Developers Console.
6. Have an admin for the relevant Google Apps domain go to
   <http://admin.google.com/> and, under Security, Advanced, Manage API Client
   Access, grant your Client ID access to the following scope:  
   `https://www.googleapis.com/auth/admin.directory.user`
7. Set up a delegated admin account in Google Apps, authorized to make changes
   to users. You will use that email address as the value for an env. var.
8. See the `local.env.dist` file to know what environment variables to provide
   when using this library.

## Example Configuration

    $googlePasswordStore = new GooglePasswordStore([
        
        // Required config fields (dummy values are shown here):
        'applicationName' => 'Name of Your Application',
        'delegatedAdminEmail' => 'some_admin@yourgoogledomain.com',
        
        // You must provide one of these two fields:
        'jsonAuthConfigBase64' => '...', // A base64-encoded string of the JSON
                                         // auth file provided by Google.
        'jsonAuthFilePath' => '/somewhere/in/your/filesystem/google-auth.json',
        
        // Optional config fields (current defaults are shown here):
        'emailFieldName' => 'email',
        'employeeIdFieldName' => 'employee_id',
        'userActiveRecordClass' => '\common\models\User',
    ]);

For details about what each of those fields is used for, see the documenting
comments in the `/src/Google.php` file.
