# Order modul

Megrendelések kezelése

## Előfeltételek

Telepíteni kell a következő modulokat.:
- https://gitlab.com/molitor/product
- https://gitlab.com/molitor/customer

## Telepítés

### Provider regisztrálása
config/app.php
```php
'providers' => ServiceProvider::defaultProviders()->merge([
    /*
    * Package Service Providers...
    */
    \Molitor\Order\Providers\OrderServiceProvider::class,
])->toArray(),
```

### Seeder regisztrálása

database/seeders/DatabaseSeeder.php
```php
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            OrderSeeder::class,
        ]);
    }
}
```

### Menüpont megjelenítése az admin menüben

Ma a Menü modul telepítve van akkor meg lehet jeleníteni az admin menüben.

```php
<?php
//Menü builderek listája:
return [
    \Molitor\Order\Services\Menu\OrderMenuBuilder::class
];
```

### Breadcrumb telepítése

A modul breadcrumbs.php fileját regisztrálni kell a configs/breadcrumbs.php fileban.
```php
<?php
'files' => [
    base_path('/vendor/molitor/order/src/routes/breadcrumbs.php'),
],
```