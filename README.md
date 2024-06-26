## Code Sample (Laravel Chat)

I built a simple Laravel chat application in about 5-6 hours:

I tried to step out of my comfort zone and work with functionalities I have never used before in Laravel, such as:

- Queues
- Broadcasting

While I have used these technologies in other languages and AWS, I have never had the opportunity to do so with Laravel.

Here's what I achieved:

- Login and Registration System
- Chat Room using Queues and Events

## System Design

A few assumptions regarding the database design:

- A user can have only one role: either "Admin" or "Normal User".
- Each room has only one admin.

In a scenario where we need to build a scalable application, roles and room admins should be normalized and saved in a separate table to establish a 1
relationship. This would provide more flexibility, allowing users to have multiple roles and rooms to have multiple admins or moderators. I opted for a simpler system design to get things done and have a running application in a short amount of time.
Chat Page

As this is a Laravel role, I opted to keep it simple by using Blade for templating and pure JavaScript to handle chat updates.

## Next Steps

Here are the next steps:
- Add Unit Tests
- Add a RedirectIfAuthenticated Middleware to redirect users away from the login/registration pages if they are already logged in
- Implement a better design
- Create a Chat Creation page to allow users with the admin role to create new rooms
- Add the ability to delete rooms
- Add the ability to edit users and assign the admin role
- Improve error messages and logging