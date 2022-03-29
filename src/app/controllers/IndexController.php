<?php

use Phalcon\Mvc\Controller;


class IndexController extends Controller
{
    public function indexAction()
    {
        
       
        // return '<h1>Hello World!</h1>';
    }
    public function addproductAction()
    {
        
       
        // return '<h1>Hello World!</h1>';
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
        // die($id);
        $eventsManager = $this->di->get('EventsManager');
        $eventsManager->fire('notifications:setDefault', $this, $id);

        $this->response->redirect('/index');


    }
    public function listproductAction() {
        $this->view->productsfind = Products:: find();
    }
    public function orderplaceAction() {
        $this->view->productsfind = Products:: find();
        // print_r($this->view->productsfind[0]);
        // die();
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
        // print_r($data);
        // die();
        
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
       
        // print_r($data);
        // die();
        // $emp = Settings::find();
        // echo '<pre>';
        // if($emp[0]==null){
        //     echo 1;
        // }else{
        //     echo 0;
        // }
        // die();
        // echo count($emp);
        // die();
        $settingsupdate = Settings:: find();
        $settingsupdate[0]->title = $data['title'];
        $settingsupdate[0]->price = $data['price'];
        $settingsupdate[0]->stock = $data['stock'];
        $settingsupdate[0]->zipcode = $data['zipcode'];
        $settingsupdate[0]->save();
        $this->response->redirect('/index');
    }
}

