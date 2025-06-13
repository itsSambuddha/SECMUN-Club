# Use the official PHP image with Apache
FROM php:8.0-apache

# Copy the current directory contents into the container's web root
COPY . /var/www/html/

# Expose port 80 for the web server
EXPOSE 80

# Set working directory
WORKDIR /var/www/html

# Enable Apache mod_rewrite (optional, if your app needs it)
RUN a2enmod rewrite

# Set permissions (optional, adjust as needed)
RUN chown -R www-data:www-data /var/www/html

# Start Apache in the foreground
CMD ["apache2-foreground"]
