<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<h1 align=center>Initial example for the Bike API using Laravel</h1>
<p align="center">
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# About APIs

- CRUD (po uzoru na projekat, gdje su Insert / Update ... odvojeni od data klase koja je mapirana na tabelu). Također model koji API vraća ne treba biti ista klasa kao ona mapirana na tabelu
- State machine (imate na ReportService implementiranu). (https://www.digitalocean.com/community/tutorials/strategy-design-pattern-in-java-example-tutorial) , poznato još kao i strategy pattern. Dakle poenta je da za svako stanje imate posebnu klasu koja upravlja akcijama
- Komunikacija sa bazom

Za početak hajmo napraviti API u laravelu + pripadajućim toolovima.


# Laravel Backend


## Database Migrations and Models

> CREATE TABLE product_type (  
    product_type_id INT PRIMARY KEY,  
    name VARCHAR(255) NOT NULL,  
    description TEXT  
);

> CREATE TABLE product (  
    product_id INT PRIMARY KEY,  
    product_type_id INT,  
    name VARCHAR(255) NOT NULL,  
    description TEXT,  
    price DECIMAL(10, 2) NOT NULL,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
    FOREIGN KEY (product_type_id) REFERENCES product_type(product_type_id)  
);

> CREATE TABLE variant (  
    variant_id INT PRIMARY KEY,  
    product_id INT,  
    name VARCHAR(255) NOT NULL,  
    value VARCHAR(255) NOT NULL,  
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,  
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,  
    FOREIGN KEY (product_id) REFERENCES product(product_id)  
);

## Create migrations and models for Product, ProductType, Variant, and any additional tables needed.
## Search with Full Text Index:  
-Implement a search endpoint that allows filtering products by name using a full-text index on the name column.
- Filter Products by Price Range:  
    - Implement a filter to allow products to be filtered by price range on variants.
- Indexing:  
    - Add indexing to the price column in the Variant table.
- Filter Products by Validity Period:  
    - Implement filtering products by valid from-to dates.
- Lazy and Eager Loading: 
    - Implement lazy and eager loading for product types from Product endpoint.

# New Model with Newest Variant
Create a new model that shows product ID, name, newest variant ID, name, along with the price.

# Authentication and Authorization
Implement authentication and authorization. Allow anonymous listing, but only users with the "Admin" role should be allowed to modify data.

# Product State Machine

Implement a state machine for products (draft, active, deleted states).
# Variants Manipulation in Draft State
Allow adding/removing variants only if the product is in the "draft" state.

# Active state
When method "Activate" is called, it should accept ValidFrom and ValidTo dates. Also, directly from state get currently logged in user and write value in the "ActivatedBy" field.

# Caching Product Type Data
Implement caching for product type data. Refresh the cache on CRUD operations.

# Logging and Exception Handling
Implement a filter to log every request, including the query string. Log exceptions with stack traces. 
Create new "UserException". If this exception is thrown, it should be visible on UI, otherwise API should return "Server-error message".

# NextJS Frontend

## UI for Product Editing
Create a UI to edit products with variants.

## UI for Product Type Editing
Create a UI with a list and a dialog for editing product types.
Separate UI for Product Details:

Create a separate UI for product details with a list and a separate details page.

## Exception Handling
Create React context which will handle all exceptions.

## Add tests 
- to everything

# **Solution** 🎉 
# ✅ Modify .env file
Replace
> #DB_CONNECTION=mysql  
#DB_HOST=127.0.0.1  
#DB_PORT=3306  
#DB_DATABASE=laravel  
#DB_USERNAME=root  
#DB_PASSWORD=   

with
>DB_CONNECTION=pgsql  
DB_HOST=127.0.0.1  
DB_PORT=5432  
DB_DATABASE=laravel  
DB_USERNAME=postgres  
DB_PASSWORD=postgres  

# ✅ Migration
## ✅ Create migrations for each of the tables:
>php artisan make:migration create_product_types_table --create=product_types  
php artisan make:migration create_products_table --create=products  
php artisan make:migration create_products_table --create=products  


In the generated migration files, you'd define the schema for the  tables, including the foreign key constraint(s):

>  public function up(): void  
    {  
        Schema::create('product_types', function (Blueprint $table)   {  
            $table->id('product_type_id');  
            $table->string('name', 255);  
            $table->text('description')->nullable();  
            //$table->timestamps();  
            /*  
            By omitting the timestamps() method,   
            Laravel will not create created_at and updated_at   columns   
            in the product_types table.   
            This is perfectly valid and allows you to define   
            the schema according to your specific requirements.  
            */  
        });  
    }  

After creating the migrations, you would run 
>php artisan migrate  
- migrate parameters:  
  - migrate:fresh  
  - migrate:install  
  - migrate:refresh  
  - migrate:reset  
  - migrate:rollback  
  - migrate:status   

to apply these changes to your database.

# ✅ Models
## ✅ Create model files for each table:
>php artisan make:model ProductType  
php artisan make:model Product  
php artisan make:model Variant


## ✅ Create controllers for each model:
>php artisan make:controller ProductTypeController --resource  
php artisan make:controller ProductController --resource  
php artisan make:controller VariantController --resource  

## ⛔ Search with Full Text Index:
Implement a search endpoint that allows filtering products by name using a full-text index on the name column.

>  public function up(): void  
    {  
        Schema::create('products', function (Blueprint $table) {  
            $table->id('product_id');  
            $table->unsignedBigInteger('product_type_id');  
            //--------------------------------------------------------------------  
            //Adds a full  text index (MySQL/PostgreSQL).  
            //--------------------------------------------------------------------  
            **$table->string('name', 255)->fullText()**;   
            //--------------------------------------------------------------------  
            $table->text('description')->nullable();  
            $table->decimal('price', 10, 2);  
            $table->timestamps();  
            $table->foreign('product_type_id')->references('product_type_id')->on('product_types')->onDelete('cascade')->onUpdate('cascade');  
           });  
        // Add the full-text index  
    //DB::statement("ALTER TABLE products ADD FULLTEXT INDEX idx_name (name)");  
    }  


## ✅ Indexing: 
~~Add indexing to the price column in the Variant table?~~  
✅ __Add indexing to the price column in the Product table (price is on the product, not variant-level)__   
Steps to do:  
- Add indexing next to the field name, with ->index().

More details on the [StackOverflow link](https://stackoverflow.com/questions/37350263/what-does-index-mean-in-laravel)


## Logging and Exception Handling:
Implement a filter to log every request, including the query string.   
Log exceptions with stack traces.  
Create new "UserException". If this exception is thrown, it should be visible on UI, otherwise API should return "Server-error message".  
Logging should be supported with winston.  
Links:  
[Steps to Create Custom Error Page in Laravel 10](https://magecomp.com/blog/create-custom-error-page-laravel-10/)


## ⛔ Define CRUD operations in the controllers from above 
### ✅ Install and prepare Swagger library  
✅ 1. Install the Package:   
First, you need to install the darkaonline/l5-swagger package via Composer. Open your terminal and run:  
> composer require darkaonline/l5-swagger  

✅ 2. Publish Configuration:   
After installing the package, publish its configuration file by running the following command:  
> php artisan vendor:publish --provider "L5Swagger\L5SwaggerServiceProvider"  

✅ 3. Configuration:  
After publishing the configuration, you can configure Swagger in the config/l5-swagger.php file. You can set options such as the path to your API annotations, the location of your Swagger UI, etc.  
✅ 4. Annotations:  
Use annotations to describe your API endpoints. You can use annotations like @SWG\Info, @SWG\Get, @SWG\Post, etc., to document your endpoints. Annotate your controller methods with these annotations.  

✅ Once your annotations are in place, you can generate the Swagger documentation by running:  
> php artisan l5-swagger:generate  

ℹ️  Additional info:   
[Laravel Api Documentation Generator With OpenAPI/Swagger Using DarkaOnLine/L5-Swagger](https://fajarwz.com/blog/laravel-api-documentation-generator-with-open-api-swagger-using-darkaonline-l5-swagger/)  
[Laravel + Swagger ](https://codingdriver.com/laravel-api-documentation-with-swagger-open-api-and-passport.html)

### ✅ READ ALL Operation
> /api/v1/products  
http://localhost:8000/api/v1/products

Swagger description:  
> http://127.0.0.1:8000/api/documentation#/Products/getProductsList



### ℹ️ Note on migrations from github
[Cloning Laravel Project from Github](https://stackoverflow.com/questions/38602321/cloning-laravel-project-from-github)  
Steps to do:  
- Clone your project
- Go to the folder application using cd command on your cmd or terminal
- Run composer install on your cmd or terminal
- Copy .env.example file to .env on the root folder.
- Open your .env file and change the database name (DB_DATABASE) to whatever you have, username (DB_USERNAME) and password (DB_PASSWORD) field correspond to your configuration.
- Run php artisan key:generate
- Run php artisan migrate
- Run php artisan serve



