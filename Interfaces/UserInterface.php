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
   * Finds the user record searching by the email (which may or may not be the primary key).
   *
   * @param string $email
   * @return bool True if the user was found.
   */
  function findByEmail ($email);

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
   * Finds the user record searching by the Token.
   *
   * @param string $token
   * @return bool True if the user was found.
   */
  function findByToken ($token);

  /**
   * Returns all fields. @see UserInterface::mergeFields () See name of fields
   *
   * @return array
   */
  function getFields ();

  /**
   * Retrieves a list of users with role level lesser or equal to the instance's user.
   *
   * @return UserInterface[]
   */
  function getUsers ();

  /**
   * Merge fields of user
   *
   * Fields:
   *
   * active
   * enabled
   * password
   * realName
   * email
   * token
   * username
   * role
   *
   * @param array $data
   */

  function mergeFields ($data);

  /**
   * Called whenever the user logs in.
   *
   * You can use this method to update a last access timestamp, for instance.
   * <p>If you throw an exception, the login is aborted and the exception message is displayed.
   */
  function onLogin ();

  /**
   * Removes the user record.
   *
   */
  function remove ();

  /**
   * Save user record.
   */
  function submit ();

  /**
   * Hashes the given password and matches it against the user's previously hashed password.
   *
   * @param string $password The password as written by the user on the login form.
   * @return bool True if the passwords match.
   */
  function verifyPassword ($password);
}
