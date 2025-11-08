<?php

namespace Molitor\Order\database\seeders;

use Illuminate\Database\Seeder;
use Molitor\Order\Models\OrderStatus;
use Molitor\User\Exceptions\PermissionException;
use Molitor\User\Services\AclManagementService;

class OrderSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        try {
            /** @var AclManagementService $aclService */
            $aclService = app(AclManagementService::class);
            $aclService->createPermission('order', 'Megrendelések kezelése', 'admin');
        } catch (PermissionException $e) {
            $this->command->error($e->getMessage());
        }

        OrderStatus::create([
            'code' => 'ordered',
            'name' => 'Megrendelve',
        ]);
    }
}
