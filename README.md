Installation Steps
1. Create New Laravel Project

composer create-project laravel/laravel multi-role-auth
cd multi-role-auth

2. Database Setup
php artisan make:migration create_super_admins_table
php artisan make:migration create_managements_table
php artisan make:migration create_principals_table
php artisan make:migration create_teachers_table
php artisan make:migration create_staff_members_table

Run migrations:
php artisan migrate

3. Create Models
php artisan make:model SuperAdmin
php artisan make:model Management
php artisan make:model Principal
php artisan make:model Teacher
php artisan make:model StaffMember

4. Configure Authentication
Edit config/auth.php to include guards and providers for all roles.

5. Create Auth Controller
php artisan make:controller Auth/AuthController

6. Create Middleware
php artisan make:middleware CheckRole

7. Create Dashboard Controllers
php artisan make:controller SuperAdmin/DashboardController
php artisan make:controller Management/DashboardController
php artisan make:controller Principal/DashboardController
php artisan make:controller Teacher/DashboardController
php artisan make:controller Staff/DashboardController

8. Set Up Routes
Configure routes in routes/web.php for all roles.

9. Create Views
Create login and dashboard views in resources/views/.

10. Seed Test Users
bash
php artisan make:seeder UsersSeeder
php artisan db:seed --class=UsersSeeder

Configuration Details
Model Implementation
Each role model should:

Extend Illuminate\Foundation\Auth\User

Implement Illuminate\Contracts\Auth\Authenticatable

Use Notifiable trait

Define proper $guard and $table properties

Example for StaffMember model:

<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Notifications\Notifiable;

class StaffMember extends Authenticatable implements AuthenticatableContract
{
    use Notifiable;

    protected $guard = 'staff';
    protected $table = 'staff_members';

}
Auth Controller
The AuthController handles:

Showing login form

Processing login attempts

Handling logout

Redirecting to proper dashboards

Key methods:

showLoginForm() - Displays the login view

login() - Processes login attempts

attemptRole() - Checks credentials against specific role tables

authenticated() - Handles post-login redirection

Middleware
The CheckRole middleware ensures users can only access their role-specific routes.

Testing Credentials
After seeding, use these test credentials:

Role	Email	Password
Super Admin	superadmin@example.com	password
Management	management@example.com	password
Principal	principal@example.com	password
Teacher	teacher@example.com	password
Staff	staff@example.com	password
Troubleshooting
Common Issues
Authentication Interface Error:

Ensure all models properly extend Authenticatable

Implement all required authentication methods

Clear caches with php artisan config:clear and composer dump-autoload

Table Not Found Errors:

Verify table names in migrations match model $table properties

Ensure migrations have run successfully

Redirection Issues:

Check route names in authenticated() method

Verify middleware is properly applied to routes

Debugging Steps
Check Laravel logs: storage/logs/laravel.log

Verify routes: php artisan route:list

Test model authentication:

bash
php artisan tinker
>>> $user = App\Models\StaffMember::first();
>>> $user instanceof Illuminate\Contracts\Auth\Authenticatable
Security Features
CSRF protection

Password hashing (bcrypt)

Rate limiting (5 attempts per minute)

Session-based authentication

Role-based access control

