## Installation

### 1. composer.json

1. Edit your file `composer.json` (in your app)
2. Add the lines below

```json
{
    "require": {
        "sumbavoyage/core": "*"
    },
    "autoload": {
        "psr-4": {
            "Svs\\Core\\": "vendor/sumbavoyage/core/"
        }
    },
    "repositories": [
        {
            "type": "package",
            "package": {
                "name": "sumbavoyage/core",
                "version": "0.1.2",
                "type": "package",
                "source": {
                    "url": "https://sumbavoyage@github.com/sumbavoyage/core.git",
                    "type": "git",
                    "reference": "main"
                }
            }
        }
    ]
}
```

### 2. composer

```bash
composer install
```

### 3. config/services.yaml

1. Edit your file `config/services.yaml` (in your app)
2. Add the lines below

```
...yaml
services:
    Svs\Core\:
        resource: '../vendor/sumbavoyage/core/'
```

### 4. config/packages/doctrine.yaml

1. Edit your file `config/packages/doctrine.yaml` (in your app)
2. Add the lines below

```
doctrine:
    orm:
        mappings:
            Core:
                is_bundle: false
                dir: '%kernel.project_dir%/vendor/sumbavoyage/core/Entity'
                prefix: 'Svs\Core\Entity'
                alias: Core
```
