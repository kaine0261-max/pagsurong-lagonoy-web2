# Pagsurong Lagonoy Tourism & Business Management System

A comprehensive web-based platform for promoting tourism and managing businesses in Lagonoy, Camarines Sur. This system connects tourists with local businesses including hotels, resorts, shops, and tourist attractions.

## Features

### For Visitors (Public)
- Browse hotels, resorts, shops, and tourist attractions
- View business profiles, galleries, and promotions
- Read and view ratings and reviews
- Explore tourist spots with detailed information
- Search and filter businesses by category

### For Customers (Registered Users)
- Create and manage user profiles
- Add items to cart and place orders
- Rate and review businesses, products, and attractions
- Like and comment on businesses and tourist spots
- Track order history and status
- Direct messaging with business owners
- Submit feedback

### For Business Owners
- Register and set up business profiles (Shop, Hotel, or Resort)
- Upload business documents for verification
- Manage product inventory and pricing
- Add and manage rooms/cottages
- Upload gallery images and promotions
- Process customer orders
- Update order status
- Communicate with customers
- View business analytics

### For Administrators
- Approve/decline business registrations
- Manage user accounts
- Upload and manage tourist spots
- Moderate content
- Archive/restore users
- View system-wide analytics
- Manage hotels, resorts, and attractions

## Technology Stack

- **Framework:** Laravel 11
- **PHP:** ^8.1
- **Database:** SQLite (configurable to MySQL/PostgreSQL)
- **Frontend:** Blade Templates, Vite
- **Authentication:** Laravel built-in authentication
- **Additional Packages:**
  - doctrine/dbal - Database abstraction layer
  - laravel/tinker - REPL for Laravel

## Requirements

- PHP >= 8.1
- Composer
- Node.js & NPM
- SQLite (or MySQL/PostgreSQL)

## Installation

1. **Clone the repository**
   ```bash
   git clone https://github.com/kaine0261-max/pagsurong-lagonoy-web2.git
   cd pagsurong-lagonoy-web2
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure your database**
   - Edit `.env` file with your database credentials
   - Default is SQLite (no additional configuration needed)

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Create storage link**
   ```bash
   php artisan storage:link
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

   Visit `http://localhost:8000` in your browser.

## Development

For development with hot module replacement:

```bash
npm run dev
```

In a separate terminal:
```bash
php artisan serve
```

## User Roles

The system supports three user roles:

1. **Customer** - Regular users who can browse and purchase
2. **Business Owner** - Manage business profiles and products
3. **Admin** - Full system administration access

## Key Modules

- **Authentication & Authorization** - Role-based access control
- **Business Management** - Profile setup, product/room management
- **Order Management** - Cart, checkout, order tracking
- **Rating & Review System** - Unified rating system for all entities
- **Messaging System** - Direct communication between users
- **Admin Panel** - Business approvals, user management, content moderation
- **Tourism Module** - Hotels, resorts, tourist spots showcase

## Database Schema

The system uses the following main tables:
- `users` - User accounts
- `businesses` - Business profiles
- `products` - Shop products
- `hotel_rooms` - Hotel room listings
- `resort_rooms` - Resort room listings
- `cottages` - Resort cottages
- `orders` - Customer orders
- `tourist_spots` - Tourist attractions
- `ratings` - Unified rating system
- `comments` - User comments and reviews

## Security

- CSRF protection on all forms
- Password hashing with bcrypt
- Role-based middleware protection
- File upload validation
- SQL injection prevention via Eloquent ORM

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

## Support

For support and questions, please open an issue in the GitHub repository.

---

Built with ❤️ for Lagonoy, Camarines Sur

## Deployment Status
- GitHub: ✅ Deployed
- Railway: 🚀 Deploying
