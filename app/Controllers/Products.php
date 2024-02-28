<?php

namespace App\Controllers;

use App\Models\ProductModel;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class Products extends ResourceController
{
    use ResponseTrait;

    //index
    public function index()
    {
        $model = new ProductModel();
        try {
            $data['product'] = $model->orderBy('product_id', 'DESC')->findAll();
            print_r($data);
            return $this->respond($data);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
    //get product by id

    public function show($id = null)
    {
        $model = new ProductModel();
        $data = $model->where('product_id', $id)->first();
        if ($data) {
            return $this->respond($data);
        } else {
            return $this->failNotFound('data not found');
        }
    }

    //create

    public function create()
    {
        $model = new ProductModel();
        $data = [
            'product_name' => $this->request->getVar('product_name'),
            'product_price' => $this->request->getVar('product_price'),
        ];

        $model->insert($data);
        $response = [
            'status' => 201,
            'error' => null,
            'message' => [
                'success' => 'successfully create data'
            ]
        ];

        return $this->respondCreated($response);
    }

    //update
    public function update($id = null)
    {
        $model = new ProductModel();
        $id = $this->request->getVar('product_id');
        $data = [
            'product_name' => $this->request->getVar('product_name'),
            'product_price' => $this->request->getVar('product_price'),
        ];

        $model->update($id,$data);
        $response = [
            'status' => 200,
            'error' => null,
            'message' => [
                'success' => 'successfully Update data'
            ]
        ];
        return $this->respond($response);
    }

    public function delete($id = null)
    {
        $model = new ProductModel();
        $data = $model->where('product_id', $id)->delete($id);

        if ($data) {
            $model->delete($id);
            $response = [
                'status' => 200,
                'error' => null,
                'message' => [
                    'success' => 'successfully Delete data'
                ]
            ];

            return $this->respondDeleted($response);
        } else {
            return $this->failNotFound('Data Not Found');
        }
    }

}
