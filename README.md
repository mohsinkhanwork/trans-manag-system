# Translation Management Service

A Laravel-based API service for managing multilingual content with tagging capabilities.

## Features

- CRUD operations for translations
- Multi-locale support (en, fr, es, etc.)
- Tagging system for contextual organization
- Search by key, tag, or content
- JSON export for frontend consumption
- Token-based authentication (Sanctum)
- Optimized for performance (caching, indexing)

## Design Choices

### Architecture
- **Layered Architecture**: Controller-Service-Repository pattern
- **SOLID Principles**: 
  - Single Responsibility (separate export service)
  - Dependency Injection (constructor injection)
  - Open/Closed (interfaces for extensibility)

### Performance
- Database indexing on frequently queried columns
- Redis caching for JSON exports
- Pagination for large datasets
- Cursor-based loading for memory efficiency

### Security
- Sanctum token authentication
- Resource policies for authorization
- Input validation on all endpoints
- Rate limiting (60 requests/minute)

### API Design
- RESTful conventions
- Consistent JSON response structure
- Semantic HTTP status codes
- Versioned API routes (/v1/)

## Setup Instructions

### Prerequisites
- PHP 8.1+
- Composer 2.0+
- MySQL 5.7+ or PostgreSQL
- Redis (for caching)

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/mohsinkhanwork/trans-manag-system 
   cd translation-service
   # Install dependencies
composer install

# Create environment file
cp .env.example .env

# Generate app key
php artisan key:generate

Edit .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=translation_db
DB_USERNAME=root
DB_PASSWORD=
