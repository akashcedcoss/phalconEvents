<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        //
    }
    public function addproductAction()
    {
        //
    }
    public function addproductdetailsAction() {
        $products = new Products();
        $data = array(
            'name' => $this->escaper->escapeHtml($this->request->getPost('name')),
            'description' => $this->escaper->escapeHtml($this->request->getPost('description')),
            'tags' => $this->escaper->escapeHtml($this->request->getPost('tags')),
            'price' => $this->escaper->escapeHtml($this->request->getPost('price')),
            'stock' => $this->escaper->escapeHtml($this->request->getPost('stock')),

        );
        
        $products->assign(
            $data,
            [
                'name',
                'description',
                'tags',
                'price',
                'stock',
            ]
        );
        $products->save();

        $id = json_decode(json_encode($products))->id;
        $eventsManager = $this->di->get('EventsManager');
        $eventsManager->fire('notifications:setDefault', $this, $id);
        $this->response->redirect('/index');
    }

    public function listproductAction() {
        $this->view->productsfind = Products:: find();
    }
    public function orderplaceAction() {
        $this->view->productsfind = Products:: find();
    }

    public function placeorderAction() {
        $orders = new Orders();
        $data = array(
            'name' => $this->escaper->escapeHtml($this->request->getPost('name')),
            'address' => $this->escaper->escapeHtml($this->request->getPost('address')),
            'zipcode' => $this->escaper->escapeHtml($this->request->getPost('zipcode')),
            'product' => $this->escaper->escapeHtml($this->request->getPost('product')),
            'quantity' => $this->escaper->escapeHtml($this->request->getPost('quantity')),

        );

        $orders->assign(
            $data,
            [
                'name',
                'address',
                'zipcode',
                'product',
                'quantity',
            ]
        );
        $orders->save();
        $id = json_decode(json_encode($orders))->order_id;

        $eventsManager = $this->di->get('EventsManager');
        $eventsManager->fire('notifications:setDefaultZipcode', $this, $id);
        
        $this->response->redirect('/index');
    }
    public function listorderAction() {
        $this->view->listorder = Orders:: find();

    }
    public function settingsAction() {
        
    }

    public function settingsdataAction() {
        $settings = new Settings();
        $data = array(
            'title' => $this->escaper->escapeHtml($this->request->getPost('title')),
            'price' => $this->escaper->escapeHtml($this->request->getPost('price')),
            'stock' => $this->escaper->escapeHtml($this->request->getPost('stock')),
            'zipcode' => $this->escaper->escapeHtml($this->request->getPost('zipcode')),
        );

        $settings->assign(
            $data,
            [
            'title',
            'price',
            'stock',
            'zipcode',
            
             ]
        );
       
        $settingsupdate = Settings:: find();
        $settingsupdate[0]->title = $data['title'];
        $settingsupdate[0]->price = $data['price'];
        $settingsupdate[0]->stock = $data['stock'];
        $settingsupdate[0]->zipcode = $data['zipcode'];
        $settingsupdate[0]->save();
        $this->response->redirect('/index');
    }
    public function eventAction() {
        echo "Hello";
    }
    public function addroleAction() {

    }
    public function addroledataAction() {
        $role = new Role();
        $data = array(
            'role' => $this->escaper->escapeHtml($this->request->getPost('newrole')),
            
        );
        $role->assign(
            $data,
            [
            'role',
            ]
        );
        $crole = Role::find();
        if (count($crole)<3) {
            $role->save();
        }
        $this->response->redirect('/index');

        
    }
    public function addcomponentAction() {
        $components = array
        (
            'index' => ['listproduct', 'listorder'],
            'secure' => ['BuildACL'],
        );
        echo "<pre>";
        print_r($components);
        $this->view->component = $components;
        
    }
}
