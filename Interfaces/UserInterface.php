<?php
namespace Electro\Interfaces;

/**
 * Represents the currently logged-in user.
 */
interface UserInterface
{
  /**
   * The administration role.
   *
   * Uses with this role can access all application features.
   * This is the most common role for backend administration users (usually the developer's clients).
   */
  const USER_ROLE_ADMIN = 2;
  /**
   * The application developer's super-user role.
   *
   * Users with this role have access to all application features plus application design/building features.
   */
  const USER_ROLE_DEVELOPER = 3;
  /**
   * A guest (anonymous) user role.
   *
   * Users with this role are not authenticated and they have access only to a very restricted set of features.
   */
  const USER_ROLE_GUEST = 0;
  /**
   * A standard user role.
   *
   * Users with this role have access to a restricted set of features.
   * This is the common role for the end-users of your app (excluding your client).
   */
  const USER_ROLE_STANDARD = 1;

  /**
   * Gets or sets the active state of the user.
   *
   * > Only active users may log in.
   *
   * > If you're not using this feature on your app (and your database users have no `active` field) you should always
   * return true.
   *
   * @param bool $set A setter value.
   * @return string
   */
  function activeField ($set = null);

  /**
   * Finds the user record searching by its ID (which may or may not be the username).
   *
   * @param string $id
   * @return bool True if the user was found.
   */
  function findById ($id);

  /**
   * Finds the user record searching by the username (which may or may not be the primary key).
   *
   * @param string $username
   * @return bool True if the user was found.
   */
  function findByName ($username);

  /**
   * Returns all fields.
   *
   * @return array
   */
  function getRecord ();

  /**
   * Retrieves a list of users with role level lesser or equal to the instance's user.
   *
   * @return UserInterface[]
   */
  function getUsers ();

  /**
   * Gets or sets the user record's primary key.
   *
   * > Note: it may be the same as the username or it may be a numeric id.
   *
   * @param string $set A setter value.
   * @return string
   */
  function idField ($set = null);

  /**
   * Gets or sets the date and time of the user's last login.
   *
   * @param string $set A datetime in <kbd>'YYYY-MM-DD hh:mm:ss'</kbd> format.
   * @return string
   */
  function lastLoginField ($set = null);

  /**
   * Called whenever the user logs in.
   *
   * You can use this method to update a last access timestamp, for instance.
   * <p>If you throw an exception, the login is aborted and the exception message is displayed.
   */
  function onLogin ();

  /**
   * Hashes the given argument and sets it as being the login password.
   *
   * @param string $set The original password as written by the user.
   * @return string The hashed password.
   *                    <p>This can be useful for checking if a user already as a password.
   *                    <p>For checking if a password matches the user's, use {@see verifyPassword()} instead.
   */
  function passwordField ($set = null);

  /**
   * Gets or sets the user's "real" name, which may be displayed on the application UI.
   *
   * > This may be the same as the username.
   *
   * @param string $set A setter value.
   * @return string
   */
  function realNameField ($set = null);

  /**
   * Gets or sets the date and time when the user record was created.
   *
   * @param string $set A datetime in <kbd>'YYYY-MM-DD hh:mm:ss'</kbd> format.
   * @return string
   */
  function registrationDateField ($set = null);

  /**
   * Gets or sets the user role.
   *
   * > The predefined roles are set as constants on {@see UserInterface}.
   *
   * @param string $set A setter value.
   * @return string
   */
  function roleField ($set = null);

  /**
   * Gets or sets a unique identifier for the user that can be used to confirm its identity in:
   * <li> password reset emails;
   * <li> registration confirmation emails;
   * <li> URL/header parameters for authenticationless access to the application.
   *
   * @param string $set A datetime in <kbd>'YYYY-MM-DD hh:mm:ss'</kbd> format.
   * @return string
   */
  function tokenField ($set = null);

  /**
   * Gets or sets the login username.
   *
   * > This may actually be an email address, for instance.
   *
   * @param string $set A setter value.
   * @return string
   */
  function usernameField ($set = null);

  /**
   * Hahses the given password amd matches it against the user's previously hashed password.
   *
   * @param string $password The password as written by the user on the login form.
   * @return bool True if the passwords match.
   */
  function verifyPassword ($password);
}
