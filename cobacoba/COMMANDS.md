# 📝 Quick Reference - Laravel Commands

## 🚀 Initial Setup

```bash
# Install dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Configure database di .env
# DB_DATABASE=sipanak
# DB_USERNAME=root
# DB_PASSWORD=

# Run migrations & seeders
php artisan migrate:fresh --seed

# Start development server
php artisan serve
```

## 🗃️ Database Commands

```bash
# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset database (drop all tables & migrate)
php artisan migrate:fresh

# Reset database + run seeders
php artisan migrate:fresh --seed

# Run specific seeder
php artisan db:seed --class=PosyanduSeeder
php artisan db:seed --class=UserSeeder

# Check migration status
php artisan migrate:status
```

## 🧹 Cache Commands

```bash
# Clear all cache
php artisan optimize:clear

# Clear specific cache
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Cache config (for production)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 🛠️ Make Commands

```bash
# Create controller
php artisan make:controller NamaController

# Create model
php artisan make:model NamaModel

# Create model + migration
php artisan make:model NamaModel -m

# Create migration
php artisan make:migration create_nama_table

# Create seeder
php artisan make:seeder NamaSeeder

# Create request (validation)
php artisan make:request StoreNamaRequest

# Create middleware
php artisan make:middleware NamaMiddleware
```

## 🔍 Inspect Commands

```bash
# List all routes
php artisan route:list

# List specific routes
php artisan route:list --name=ibu

# Show application info
php artisan about

# Check application environment
php artisan env

# List all artisan commands
php artisan list
```

## 🐛 Debugging

```bash
# Laravel Tinker (REPL)
php artisan tinker

# Examples in tinker:
>>> \App\Models\User::all();
>>> \App\Models\Posyandu::find(1);
>>> \App\Models\Ibu::count();
>>> auth()->user();

# Check errors in log
tail -f storage/logs/laravel.log   # Linux/Mac
Get-Content storage/logs/laravel.log -Wait -Tail 50   # Windows PowerShell
```

## 📊 Database Queries (Tinker)

```bash
php artisan tinker

# Get all users
>>> \App\Models\User::all();

# Find user by ID
>>> \App\Models\User::find(1);

# Get user by email
>>> \App\Models\User::where('email', 'admin@sipanak.id')->first();

# Count records
>>> \App\Models\Ibu::count();
>>> \App\Models\Anak::count();

# Create new record
>>> \App\Models\Posyandu::create(['nama' => 'Test', 'desa' => 'Test Desa', 'puskesmas' => 'Test Puskesmas']);

# Update record
>>> $user = \App\Models\User::find(1);
>>> $user->name = 'New Name';
>>> $user->save();

# Delete record
>>> $user = \App\Models\User::find(1);
>>> $user->delete();

# Raw query
>>> DB::select('SELECT * FROM users LIMIT 5');
```

## 🔐 User Management (Tinker)

```bash
php artisan tinker

# Create admin
>>> \App\Models\User::create([
...   'name' => 'Admin Baru',
...   'email' => 'admin.baru@sipanak.id',
...   'password' => bcrypt('password'),
...   'role' => 'admin',
...   'email_verified_at' => now()
... ]);

# Create kader
>>> \App\Models\User::create([
...   'name' => 'Kader Baru',
...   'email' => 'kader.baru@sipanak.id',
...   'password' => bcrypt('password'),
...   'role' => 'kader',
...   'posyandu_id' => 1,
...   'email_verified_at' => now()
... ]);

# Reset password
>>> $user = \App\Models\User::where('email', 'admin@sipanak.id')->first();
>>> $user->password = bcrypt('newpassword');
>>> $user->save();

# Change role
>>> $user = \App\Models\User::find(1);
>>> $user->role = 'dokter';
>>> $user->save();
```

## 📈 Generate Sample Data (Tinker)

```bash
php artisan tinker

# Create sample Ibu
>>> \App\Models\Ibu::create([
...   'nik' => '3201011234567890',
...   'nama' => 'Ibu Test',
...   'tgl_lahir' => '1990-01-01',
...   'hp' => '081234567890',
...   'alamat' => 'Jl. Test No. 1',
...   'posyandu_id' => 1,
...   'hpht' => now()->subMonths(3),
...   'tp' => now()->addMonths(6),
...   'created_by' => 1
... ]);

# Create sample Anak
>>> \App\Models\Anak::create([
...   'ibu_id' => 1,
...   'nama' => 'Anak Test',
...   'tgl_lahir' => '2023-01-01',
...   'jk' => 'L',
...   'bb_lahir' => 3.2,
...   'tb_lahir' => 48.5
... ]);
```

## 🔄 Git Commands (untuk version control)

```bash
# Check status
git status

# Add all changes
git add .

# Commit
git commit -m "Your commit message"

# Push to remote
git push origin main

# Pull from remote
git pull origin main

# Create new branch
git checkout -b feature/new-feature

# Switch branch
git checkout main
```

## ⚙️ Environment-specific

### Development
```bash
# Run with specific port
php artisan serve --port=8001

# Run with specific host
php artisan serve --host=192.168.1.100
```

### Production
```bash
# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set correct permissions (Linux)
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 🧪 Testing Commands

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/IbuTest.php

# Run with coverage
php artisan test --coverage
```

## 📦 Composer Commands

```bash
# Install packages
composer install

# Update packages
composer update

# Dump autoload
composer dump-autoload

# Require new package
composer require vendor/package

# Remove package
composer remove vendor/package
```

## 🔧 Troubleshooting

```bash
# Fix "Class not found"
composer dump-autoload

# Fix permissions (Linux)
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

# Fix ".env not found"
cp .env.example .env
php artisan key:generate

# Fix "419 CSRF token mismatch"
php artisan config:clear
php artisan cache:clear

# Fix "Access denied for user"
# Check .env database credentials

# Fix "No application encryption key"
php artisan key:generate
```

## 📱 Shortcuts (PowerShell)

```powershell
# Create aliases in PowerShell profile
# File: $PROFILE (run: notepad $PROFILE)

function pa { php artisan $args }
function pam { php artisan migrate $args }
function pas { php artisan serve }
function pac { php artisan cache:clear; php artisan config:clear; php artisan view:clear }
function pat { php artisan tinker }

# Usage after restart PowerShell:
# pa migrate
# pas
# pac
```

## 🎯 Common Workflows

### Add New Feature
```bash
# 1. Create migration
php artisan make:migration create_new_table

# 2. Create model
php artisan make:model NewModel

# 3. Create controller
php artisan make:controller NewController

# 4. Create request
php artisan make:request StoreNewRequest

# 5. Run migration
php artisan migrate

# 6. Test
php artisan tinker
```

### Reset Everything
```bash
composer dump-autoload
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear
php artisan migrate:fresh --seed
```

### Deploy to Production
```bash
# 1. Pull latest code
git pull origin main

# 2. Install dependencies
composer install --optimize-autoloader --no-dev

# 3. Run migrations
php artisan migrate --force

# 4. Clear & cache
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 5. Fix permissions
chmod -R 775 storage bootstrap/cache

# 6. Restart queue (if using)
php artisan queue:restart
```

---

**Tip**: Bookmark halaman ini untuk referensi cepat! 🚀
