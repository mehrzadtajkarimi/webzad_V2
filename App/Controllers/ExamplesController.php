<?php

// **************************************************************** add namespace

use App\Controllers\Controller;
use App\Models\Example;
use App\Utilities\FlashMessage;

class ExamplesController  extends Controller
{
    private $exampleModel;

    public function __construct()
    {
        parent::__construct();
        $this->exampleModel = new Example();
    }

    public function index()
    {
        $data = array(
            'Examples' => 'Examples',
        );
        return view('Backend.examples.index', $data);
    }

    public function create()
    {
        $params = $this->request->params();
        $params_create = array(
            'name' => $params['example-name'],
        );
        $example_id = $this->exampleModel->create_example($params_create);
        if ($example_id) {
            FlashMessage::add("ایجاد مثال موفقیت انجام شد");
        } else {
            FlashMessage::add(" مشکلی در ایجاد مثال رخ داد ", FlashMessage::ERROR);
        }
        return $this->request->redirect('admin/example');
    }

    public function store()
    {
        $params = $this->request->params();
        $params_create = array(
            'name' => $params['example-name'],
        );
        $example_id = $this->exampleModel->create_example($params_create);
        if ($example_id) {
            FlashMessage::add("ایجاد مثال موفقیت انجام شد");
        } else {
            FlashMessage::add(" مشکلی در ایجاد مثال رخ داد ", FlashMessage::ERROR);
        }
        return $this->request->redirect('admin/example');
    }

    public function edit()
    {
        $id = $this->request->get_param('id');
        $example = $this->exampleModel->read_example($id);

        $data = array(
            'example' => $example,
        );
        view('Backend.example.edit', $data);
    }

    public function update()
    {
        $params = $this->request->params();
        $example_id = $this->request->get_param('id');
        $params_updated = array(
            'name'   => $params['example-name'],
        );
        $this->exampleModel->update_example($params_updated, $example_id);

        FlashMessage::add("مقادیر  با موفقیت در دیتابیس ذخیره شد");
        return $this->request->redirect('admin/example');
    }

    public function destroy()
    {
        $id = $this->request->get_param('id');
        $is_deleted_example = $this->exampleModel->delete_example($id);
        if ($is_deleted_example) {
            FlashMessage::add("مقادیر  با موفقیت از دیتابیس حذف شد");
            return $this->request->redirect('admin/example');
        }
        FlashMessage::add(" مشکلی در حذف مثال پیش آمده است", FlashMessage::ERROR);
        return $this->request->redirect('admin/example');
    }
}
