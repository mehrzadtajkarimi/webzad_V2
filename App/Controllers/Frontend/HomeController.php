<?php

namespace App\Controllers\Frontend;

use App\Controllers\Controller;
use App\Models\Work_sample;

class HomeController extends Controller
{
    private $work_sampleModel;

    public function __construct()
    {
        parent::__construct();
        $this->work_sampleModel = new Work_sample();

    }

    public function index()
    {
        $data = array();
        return view('Frontend.index', $data);
    }
    public function work_samples()
    {

        $type =   $this->request->input('type');

       $work_sample= $this->work_sampleModel->read_work_sample($type);
        echo json_encode([
            'status' => 'success',
            'data' => $work_sample
        ]);
    }
}
