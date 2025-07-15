<?php

namespace App\Controllers;

use CodeIgniter\Events\Events;
use CodeIgniter\HTTP\RedirectResponse;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Exceptions\ValidationException;
use CodeIgniter\Shield\Models\UserModel;
use CodeIgniter\Shield\Traits\Viewable;

class RegisterController extends \CodeIgniter\Shield\Controllers\RegisterController
{
    use Viewable;

    /**
     * Attempts to register the user.
     */
    public function registerAction(): RedirectResponse
    {
        if (auth()->loggedIn()) {
            return redirect()->to(config('Auth')->registerRedirect());
        }

        // Check if registration is allowed
        if (! setting('Auth.allowRegistration')) {
            return redirect()->back()->withInput()
                ->with('error', lang('Auth.registerDisabled'));
        }

        $users = $this->getUserProvider();

        // Validate here first
        $rules = $this->getValidationRules();

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Save the user
        $allowedPostFields = array_keys($rules);
        $user              = $this->getUserEntity();
        $user->fill($this->request->getPost($allowedPostFields));

        // Workaround for email only registration/login
        if ($user->username === null) {
            $user->username = null;
        }

        log_message('debug', 'Attempting to save user to `users` table.');
        try {
            $users->save($user);
            log_message('debug', 'User saved successfully to `users` table.');
        } catch (ValidationException $e) {
            log_message('error', 'ValidationException during user save: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('errors', $users->errors());
        } catch (\Throwable $e) { // Catch any other general exceptions
            log_message('error', 'General exception during user save: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'An unexpected error occurred during registration.');
        }

        // To get the complete user object with ID, we need to get from the database
        $insertedId = $users->getInsertID();
        log_message('debug', 'Attempting to retrieve user with ID: ' . $insertedId);
        $user = $users->findById($insertedId);

        if ($user === null) {
            log_message('error', 'Failed to retrieve user object after insert. Inserted ID: ' . $insertedId);
            return redirect()->back()->withInput()->with('error', 'Registration failed: User record not found after creation.');
        }

        log_message('debug', 'User ID for group assignment: ' . $user->id);

        // ❗ Custom logic starts here
        // Assign newly registered user to the 'user' group by default.
        $user->addGroup('user'); // This operation might internally trigger auth_identities insert
        log_message('debug', 'User added to "user" group.');
        // ❗ Custom logic ends here

        Events::trigger('register', $user);

        /** @var \CodeIgniter\Shield\Authentication\Authenticators\Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        // If an action has been defined for registration, start it up.
        if ($authenticator->hasAction()) {
            return redirect()->route('auth-action-show');
        }

        // Set the user active
        $user->activate();

        // Success! Redirect to the login page.
        log_message('debug', 'Registration successful. Redirecting to login.');
        return redirect()->route('login')
            ->with('message', lang('Auth.registerSuccess'));
    }

    /**
     * Returns the rules that should be used for validation.
     *
     * @return array<string, array<string, list<string>|string>>
     */
    protected function getValidationRules(): array
    {
        // Get default registration rules from Shield
        $rules = parent::getValidationRules();

        // Remove the custom access code rule as it's no longer needed for 'user' group registration.
        unset($rules['access_code']);

        return $rules;
    }
}