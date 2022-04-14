<?php

namespace console\controllers;

use Yii;
use yii\console\Controller;
/**
 * Инициализатор RBAC выполняется в консоли php yii my-rbac/init
 */
class MyRbacController extends Controller {

    public function actionInit() {
        $auth = Yii::$app->authManager;
        
        $auth->removeAll(); //На всякий случай удаляем старые данные из БД...
        
        // Создадим роли админа и редактора новостей
        $admin = $auth->createRole('admin');
        $manager = $auth->createRole('manager');

        $auth->add($admin);
        $auth->add($manager);

        $indexClient  = $auth->createPermission('indexClient');
        $viewClient   = $auth->createPermission('viewClient');
        $createClient = $auth->createPermission('createClient');
        $updateClient = $auth->createPermission('updateClient');
        $deleteClient = $auth->createPermission('deleteClient');

        $auth->add($indexClient);
        $auth->add($viewClient);
        $auth->add($createClient);
        $auth->add($updateClient);
        $auth->add($deleteClient);

        $indexOrder  = $auth->createPermission('indexOrder');
        $viewOrder   = $auth->createPermission('viewOrder');
        $createOrder = $auth->createPermission('createOrder');
        $updateOrder = $auth->createPermission('updateOrder');
        $deleteOrder = $auth->createPermission('deleteOrder');
        $activateOrder = $auth->createPermission('activateOrder');

        $auth->add($indexOrder);
        $auth->add($viewOrder);
        $auth->add($createOrder);
        $auth->add($updateOrder);
        $auth->add($deleteOrder);
        $auth->add($activateOrder);

        $indexUser  = $auth->createPermission('indexUser');
        $viewUser   = $auth->createPermission('viewUser');
        $createUser = $auth->createPermission('createUser');
        $updateUser = $auth->createPermission('updateUser');
        $deleteUser = $auth->createPermission('deleteUser');

        $auth->add($indexUser);
        $auth->add($viewUser);
        $auth->add($createUser);
        $auth->add($updateUser);
        $auth->add($deleteUser);

        $auth->addChild($admin, $indexClient);
        $auth->addChild($admin, $viewClient);
        $auth->addChild($admin, $createClient);
        $auth->addChild($admin, $updateClient);
        $auth->addChild($admin, $deleteClient);

        $auth->addChild($admin, $indexOrder);
        $auth->addChild($admin, $viewOrder);
        $auth->addChild($admin, $createOrder);
        $auth->addChild($admin, $updateOrder);
        $auth->addChild($admin, $deleteOrder);
        $auth->addChild($admin, $activateOrder);

        $auth->addChild($manager, $indexOrder);
        $auth->addChild($manager, $viewOrder);
        $auth->addChild($manager, $createOrder);
        $auth->addChild($manager, $updateOrder);
        $auth->addChild($manager, $deleteOrder);
        $auth->addChild($manager, $activateOrder);

        $auth->addChild($admin, $indexUser);
        $auth->addChild($admin, $viewUser);
        $auth->addChild($admin, $createUser);
        $auth->addChild($admin, $updateUser);
        $auth->addChild($admin, $deleteUser);

        // Назначаем роль admin пользователю с ID 1
        $auth->assign($admin, 1); 
        
        // Назначаем роль manager пользователю с ID 2
        $auth->assign($manager, 2);
    }
}