<?php
use Phalcon\Mvc\Controller;
use Phalcon\Acl\Adapter\Memory;
use Phalcon\Acl\Role;
use Phalcon\Acl\Component;

public function BuildACLAction() {
    $aclFile = APP_PATH. '/security/acl/cache';
    if(true !== is_file($aclFile)) {
        
        $acl = new Memory();

        $acl->addRole('manager');
        $acl->addRole('accounting');
        $acl->addRole('guest');
        $acl->addRole('admin');


        $acl->addComponent(
            'index',
            [
                'event'
                
            ]
        );

        $acl->allow('manager', 'index', 'event');
        $acl->allow('admin', '*', '*');

        $acl->deny('guest', '*', '*');

        file_put_contents(
            $aclfile,
            serialize($acl)
        );

    }else {
        $acl = unserialize(
            file_get_contents($aclFile)
        );
    }
    if (true === $acl->isAllowed('manager', 'index', 'event')) {
        echo "Access Granted :)";
    } else {
        echo "Access Denied :(";
    }
}