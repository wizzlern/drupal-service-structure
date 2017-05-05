<?php

/**
 * @file
 * Local development override configuration feature.
 *
 * @see sites/example.settings.local.php
 */

// Performance settings.
$config['system.logging']['error_level'] = 'all';

// File system.
$settings['file_public_path'] = 'sites/default/files';
$settings['file_private_path'] = '';

// Add a local services file.
$settings['container_yamls'][] = __DIR__ . '/services.local.yml';

// Permanently disable caches.
$settings['cache']['bins']['render'] = 'cache.backend.null';
$settings['cache']['bins']['dynamic_page_cache'] = 'cache.backend.null';
