## RNCONTACT
<p>
an outline a modern contact list backend with custom login, register, update, password reset, and forgot password system in Laravel API using Sanctum for a mobile app (REACT NATIVE).
</p>

# routes list

# Public routes

- register: POST request to register a new user.
- login: POST request to log in an existing user.
/forgot-password: POST request to send a password reset link to the user's email.
- reset-password: POST request to reset the user's password.

# Protected routes

- logout: POST request to log out the authenticated user.
- auth/refresh: POST request to refresh the access token of the authenticated user.

# Contacts routes (protected)

- contacts: GET request to fetch all contacts.
- contacts: POST request to create a new contact.
- contacts/{id}: GET request to fetch a specific contact by its ID.
- contacts/{id}: PUT request to update a specific contact by its ID.
- contacts/{id}: DELETE request to delete a specific contact by its ID.

- POST /contacts/{id}/add-to-favorites: Adds a contact to the favorite list.
- POST /contacts/{id}/remove-from-favorites: Removes a contact from the favorite list.
