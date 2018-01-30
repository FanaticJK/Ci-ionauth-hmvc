<?php

/**
 * Created by PhpStorm.
 * User: Ultrabyte
 * Date: 8/23/2017
 * Time: 6:42 AM
 */
class FileUpload
{
    /**
     * @param
     *
     * @return mixed
     */
    public function __construct()
    {

    }

    /**
     * @param
     *
     * @return mixed
     */
    public function uploadFile($files, $doc, $name, $insert_id, $table = "")
    {
        $CI = &get_instance();
        $CI->load->model('mymodel');
        $path = './upload/profile';
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        $config = array(
            'upload_path' => $path,
            'allowed_types' => 'gif|jpg|png|jpeg|JPG|PNG|GIF|JPEG',
            'overwrite' => 1,
        );
        $randomString = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 5);
        $config['file_name'] = $randomString . '-' . $files['name'];
        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);
        if (!$CI->upload->do_upload($name)) {
            $error = array('error' => $CI->upload->display_errors());
            print_r($error);
        } else {
            $data = array();
            $data = array(
                $doc => 'upload/profile/' . $randomString . '-' . $files['name']
            );
            try {
                $CI->mymodel->edit($table, $data, 'id', $insert_id);
            } catch (RuntimeException $e) {
                echo $e->getMessage();
            }
        }
    }

    /**
     * @param
     *
     * @return mixed
     */
    public function editUploadFile($files, $doc, $name, $insert_id, $table = "")
    {
        $CI = &get_instance();
        $CI->load->model('mymodel');
        $path = './upload/profile';
        $randomString = substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10 / strlen($x)))), 1, 5);
        $filename = $randomString . '-' . $files['name'];
        $config = array(
            'upload_path' => $path,
            'allowed_types' => 'gif|jpg|png|jpeg|JPG|PNG|GIF|JPEG',
            'overwrite' => 1,
            'file_name' => $filename
        );

        $CI->load->library('upload', $config);
        $CI->upload->initialize($config);

        $profilefile = $CI->mymodel->get($table, 'profile_image_url', 'id=' . $insert_id);
//        var_dump(base_url() . $profilefile[0]['profile1']);
        if (getimagesize('./' . $profilefile[0]['profile_image_url']) !== false) {
            unlink('./' . $profilefile[0]['profile_image_url']);
        }

        if (!$CI->upload->do_upload($name)) {
            $error = array('error' => $CI->upload->display_errors());
            print_r($error);
        } else {
            $data = array();
            $data = array(
                'profile_image_url' => 'upload/profile/' . $filename
            );
            try {
                $CI->mymodel->edit($table, $data, 'id', $insert_id);
            } catch (RuntimeException $e) {

                echo $e->getMessage();

            }
        }
    }
}