FROM php:8.2-apache

# Install MySQL extension
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

WORKDIR /var/www/html

# Copy all project files to subdirectory
COPY . /var/www/html/erqah-hospital/

# Create Apache config for subdirectory routing
RUN echo '<Directory /var/www/html/erqah-hospital>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
    </Directory>\n\
    Alias /erqah-hospital /var/www/html/erqah-hospital' > /etc/apache2/conf-available/erqah-hospital.conf \
    && a2enconf erqah-hospital

# Create startup script
RUN echo '#!/bin/bash\n\
    echo "Initializing database via PHP..."\n\
    php /var/www/html/erqah-hospital/init_db.php\n\
    echo "Starting Apache..."\n\
    apache2-foreground\n\
    ' > /usr/local/bin/start.sh && chmod +x /usr/local/bin/start.sh

# Remove unnecessary files from the image
RUN rm -f /var/www/html/erqah-hospital/Dockerfile \
    /var/www/html/erqah-hospital/.dockerignore \
    /var/www/html/erqah-hospital/README.md \
    /var/www/html/erqah-hospital/*.sql

# Set permissions
RUN chown -R www-data:www-data /var/www/html/erqah-hospital

EXPOSE 80

CMD ["/usr/local/bin/start.sh"]
