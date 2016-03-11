<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH."modules/auth/controllers/Auth.php";

class User extends Auth
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('usermodel');

        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }elseif(!$this->ion_auth->is_admin())
        {
            redirect('auth/index', 'refresh');
        }

    }


    function account($id=FALSE)
    {

        $id || $id = $this->session->userdata('user_id');


        $this->data['users'] = $this->ion_auth->user($id)->result();


        foreach ($this->data['users'] as $k => $user)
        {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }


        $this->_render_page('auth/view_account',$this->data);
    }


    function create_user()
    {
        $this->data['title'] = "Create User";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        $this->data['companyid']=$this->mymodel->getValue('name','admin','groups','id');
        $this->data['superadminid']=$this->mymodel->getValue('name','superadmin','groups','id');
        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('accesstype', $this->lang->line('create_user_validation_accesslevel_label'), 'required');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'required');

        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
//        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'),'required|trim|integer');

        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');
        $this->form_validation->set_rules('address', $this->lang->line('create_user_validation_address_label'), 'required');
//        $this->form_validation->set_rules('date_of_birth', $this->lang->line('create_user_validation_date_of_birth_label'), 'required');
//        $this->form_validation->set_rules('age',$this->lang->line('create_user_validation_age_label'), 'required|integer');
//        $this->form_validation->set_rules('gender',$this->lang->line('create_user_validation_gender_label'), 'required');


//		$this->form_validation->set_rules('zone[]',$this->lang->line('create_user_validation_zone_label'), 'required');
//		$this->form_validation->set_rules('supervise',$this->lang->line('create_user_validation_supervisior_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $result=true;

            if($_FILES["image_upload"]["size"]>0)
            {
                $folder_file=$this->mymodel->getValue('id',$this->input->post('company'),'company','name');
                $target='upload';
                $thumb=array('dest' =>$target.'/'.$folder_file,'size' => array('w' => 257,'h' =>218), 'ratio' => true);
                $result=upload_image('image_upload',$target,$thumb, $folder_file);

            }

            if($result)

            {

                if(isset($result['thumb_dest']))
                {$val=$result['thumb_dest'];}
                else{$val='';}

                $email    = strtolower($this->input->post('email'));
                $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
                $password = $this->input->post('password');

                $additional_data = array(

                    'first_name' => $this->input->post('first_name'),
                    'last_name'  => $this->input->post('last_name'),
                    'company'    => $this->input->post('company'),
                    'phone'      => $this->input->post('phone'),

                    'accesstype' => $this->input->post('accesstype'),
                    'age'        => $this->input->post('age'),
                    'address'    => $this->input->post('address'),
                    'date_of_birth'=>$this->input->post('date_of_birth'),

                    'supervisior'	=>$this->input->post('supervise'),
                    'image_path'    =>$val
                );
                $group=array($this->input->post('accesstype'));
                $zone=$this->input->post('zone');
            }





        }
        if ($this->form_validation->run() == true && $result== true && $this->ion_auth->register($identity, $password, $email, $additional_data,$group))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            if($this->mymodel->user_zone($zone,$id)==true)
            {

                $this->session->set_flashdata('create_user_message', $this->ion_auth->messages());
                redirect("auth/user/create_user");
            }
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            $data['groups']=$this->ion_auth->groups()->result();

            $this->data['options']=$this->ion_auth->dropdown_array('id','name','groups');
            $this->data['option1']=$this->ion_auth->dropdown_array('id','name','company');
            $this->data['options2']=$this->ion_auth->checkbox('id','zone_name','zone');




            $this->data['first_name'] = array(

                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'placeholder'=>'please type your first name',
                'value' => $this->form_validation->set_value('first_name'),
            );

            $this->data['last_name'] = array(

                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'placeholder'=>'please type your last name',
                'value' => $this->form_validation->set_value('last_name'),
            );


            $this->data['email'] = array(

                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'placeholder'=>'example@mail.com',
                'value' => $this->form_validation->set_value('email'),
            );

            $this->data['company'] = array(

                'name'  => 'company',
                'id'    => 'company',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('company'),
            );

            $this->data['password'] = array(

                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'placeholder'=>'*********',
                'value' => $this->form_validation->set_value('password'),
            );

            $this->data['password_confirm'] = array(
                'name'	=>'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'placeholder'=>'*********',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->data['phone'] = array(

                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'placeholder'=>'please type your contact no',
                'value' => $this->form_validation->set_value('phone'),
            );

            $this->data['address']=array(

                'name'=>'address',
                'id'=>'address',
                'type'=>'text',
                'placeholder'=>'please type your address',
                'value'=>$this->form_validation->set_value('address')
            );

            $this->data['dob']=array(

                'name'=>'date_of_birth',
                'id'=>'date_of_birth',
                'type'=>'date',
                'value'=>$this->form_validation->set_value('date_of_birth')
            );
            $this->data['supervisior']=array(

                'name'=>'supervise',
                'id'=>'supervise',
                'type'=>'text',
                'value'=>$this->form_validation->set_value('supervise')
            );

            $this->data['age']=array(

                'name'=>'age',
                'id'=>'age',
                'type'=>'number',
                'value'=>$this->form_validation->set_value('age')
            );

            $this->data['gender']=array(
                'name'=>"gender",
                'id'=>"gender",
                'type'=>"radio",


            );
            $this->data['gender1']=array(
                'name'=>'gender',
                'id'=>'gender',
                'type'=>'radio',

            );
            $this->data['image_upload'] = array(
                'name' => 'image_upload',
                'id'   => 'image_upload',
                'type' => 'file'
            );


            $this->_render_page('auth/create_user',$this->data);
        }
    }

    // edit a user
    function edit_user($id)
    {

        $this->data['title'] = "Edit User";

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
        }
        $tables = $this->config->item('tables','ion_auth');
        $user = $this->ion_auth->user($id)->row();
        $groups=$this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();
        $this->data['zoneselection']=$this->mymodel->get('users_zone','zone_id','users_id='.$id);


        // validate form input
        $this->form_validation->set_rules('accesstype', $this->lang->line('create_user_validation_accesslevel_label'), 'required');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'required');

        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');

        $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');

        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'),'required|trim|integer');


        $this->form_validation->set_rules('address', $this->lang->line('create_user_validation_address_label'), 'required');
        $this->form_validation->set_rules('date_of_birth', $this->lang->line('create_user_validation_date_of_birth_label'), 'required');
        $this->form_validation->set_rules('age',$this->lang->line('create_user_validation_age_label'), 'required|integer');
        $this->form_validation->set_rules('gender',$this->lang->line('create_user_validation_gender_label'), 'required');


        $this->form_validation->set_rules('zone[]', $this->lang->line('create_user_validation_zone_label'), 'required');
        $this->form_validation->set_rules('supervise',$this->lang->line('create_user_validation_supervisior_label'), 'required');


        if (isset($_POST) && !empty($_POST))
        {
            print_r($_POST);
            die();
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                show_error($this->lang->line('error_csrf'));
            }

            // update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }
            $result=TRUE;

            if($_FILES["image_upload"]["size"]>0)
            {
                $folder_file=$this->mymodel->getValue('id',$this->input->post('company'),'company','name');

                $target='upload';
                $thumb=array('dest' =>$target.'/'.$folder_file,'size' => array('w' => 257,'h' =>218), 'ratio' => true);
                $result=upload_image('image_upload',$target,$thumb, $folder_file);

            }

            if ($this->form_validation->run() === TRUE && $result==TRUE)
            {
                echo"abcd";
                die();
                $data = array(
                    'first_name' => $this->input->post('first_name'),
                    'last_name'  => $this->input->post('last_name'),
                    'company'    => $this->input->post('company'),
                    'phone'      => $this->input->post('phone'),
                    'email'       =>$this->input->post('email'),
                    'accesstype' => $this->input->post('accesstype'),
                    'age'        => $this->input->post('age'),
                    'address'    => $this->input->post('address'),
                    'date_of_birth'=>$this->input->post('date_of_birth'),

                    'supervisior'   =>$this->input->post('supervise'),
                    'image_path'   =>(isset($result['thumb_dest']))?$result['thumb_dest']:$user->image_path
                );



                // update the password if it was posted
                if ($this->input->post('password'))
                {
                    $data['password'] = $this->input->post('password');
                }



                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin())
                {

                    //Update the groups user belongs to
                    $groupData = array($this->input->post('accesstype'));


                    if (isset($groupData) && !empty($groupData)) {


                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }

                    }

                }

                // check to see if we are updating the user
                if($this->ion_auth->update($user->id,$data)&&$this->mymodel->user_zone_update($zone,$id)==true)
                {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('success_message', $this->ion_auth->messages() );
                    if ($this->ion_auth->is_admin())
                    {
                        echo"abcd";
                        die();
                        redirect('auth');
                    }
                    else
                    {
                        echo"xyz";
                        die();
                        redirect('/', 'refresh');
                    }

                }
                else
                {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('success_message', $this->ion_auth->errors() );
                    if ($this->ion_auth->is_admin())
                    {
                        echo"bcd";
                        die();
                        redirect('auth');
                    }
                    else
                    {
                        echo"123";
                        die();
                        redirect('/', 'refresh');
                    }

                }

            }

        }

        // display the edit user form
        $this->data['csrf'] = $this->_get_csrf_nonce();

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('success_message')));

        // pass the user to the view
        $this->data['user'] = $user;
        $this->data['groups'] = $groups;
        $this->data['currentGroups'] = $currentGroups;
        $this->data['options']=$this->ion_auth->dropdown_array('id','name','groups');
        $this->data['option1']=$this->ion_auth->dropdown_array('id','name','company');
        $this->data['options2']=$this->ion_auth->checkbox('id','zone_name','zone');



        $this->data['first_name'] = array(

            'name'  => 'first_name',
            'id'    => 'first_name',
            'type'  => 'text',
            'placeholder'=>'please type your first name',
            'value' => $this->form_validation->set_value('first_name',$user->first_name),
        );

        $this->data['last_name'] = array(

            'name'  => 'last_name',
            'id'    => 'last_name',
            'type'  => 'text',
            'placeholder'=>'please type your last name',
            'value' => $this->form_validation->set_value('last_name',$user->last_name),
        );


        $this->data['email'] = array(

            'name'  => 'email',
            'id'    => 'email',
            'type'  => 'text',
            'placeholder'=>'example@mail.com',
            'value' => $this->form_validation->set_value('email',$user->email),
        );

        $this->data['company'] = array(

            'name'  => 'company',
            'id'    => 'company',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('company',$user->company),
        );



        $this->data['phone'] = array(

            'name'  => 'phone',
            'id'    => 'phone',
            'type'  => 'text',
            'placeholder'=>'please type your contact no',
            'value' => $this->form_validation->set_value('phone',$user->phone),
        );

        $this->data['address']=array(

            'name'=>'address',
            'id'=>'address',
            'type'=>'text',
            'placeholder'=>'please type your address',
            'value'=>$this->form_validation->set_value('address',$user->address)
        );

        $this->data['dob']=array(

            'name'=>'date_of_birth',
            'id'=>'date_of_birth',
            'type'=>'date',
            'value'=>$this->form_validation->set_value('date_of_birth',$user->date_of_birth)
        );
        $this->data['supervisior']=array(

            'name'=>'supervise',
            'id'=>'supervise',
            'type'=>'text',
            'value'=>$this->form_validation->set_value('supervise',$user->supervisior)
        );

        $this->data['age']=array(

            'name'=>'age',
            'id'=>'age',
            'type'=>'number',
            'value'=>$this->form_validation->set_value('age',$user->age)
        );

        $this->data['gender']=array(
            'name'=>"gender",
            'id'=>"gender",
            'type'=>"radio",


        );
        $this->data['gender1']=array(
            'name'=>'gender',
            'id'=>'gender',
            'type'=>'radio',

        );
        $this->data['image_upload'] = array(
            'name' => 'image_upload',
            'id'   => 'image_upload',
            'type' => 'file'
        );

        $this->_render_page('auth/edit_user', $this->data);
    }


    function company()
    {

        $this->data['title'] = "Create company";

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {

            redirect('auth','refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        if($this->input->post('submit',true))
        {

            // validate form input
            $this->form_validation->set_rules('com_name', $this->lang->line('create_company_validation_name_label'), 'required');

            $this->form_validation->set_rules('email', $this->lang->line('create_company_validation_email_label'), 'required|valid_email|is_unique[' . $tables['company'] . '.email]');

            $this->form_validation->set_rules('phone', $this->lang->line('create_company_validation_phone_label'), 'required|trim|integer');
            $this->form_validation->set_rules('address', $this->lang->line('create_company_validation_address_label'), 'required|trim');
            $this->form_validation->set_rules('bgcolor', $this->lang->line('create_company_validation_color_label'), 'required|trim');
        }

        if ($this->form_validation->run($this) == true)
        {
            $result=true;
            $folder_file=$this->input->post('com_name');
            $target='upload';
            $thumb=array('dest' =>$target.'/'.$folder_file,'size' => array('w' => 257,'h' =>218), 'ratio' => true);
            $result=upload_image('image_upload',$target,$thumb, $folder_file) ;
            if($result)
            {
                $email    = strtolower($this->input->post('email'));
                $identity = ($identity_column==='email') ? $email : $this->input->post('identity');

                $data = array(
                    'name' => $this->input->post('com_name'),
                    'email'=>$this->input->post('email'),
                    'address'=>$this->input->post('address'),
                    'contact'=>$this->input->post('phone'),
                    'description'=>$this->input->post('about_com'),
                    'bgcolor'=>$this->input->post('bgcolor'),
                    'logo_name'=>$result['fullname'],
                    'logo_path'=>$result['thumb_dest']

                );

            }

        }
        if ($this->form_validation->run() == true  && $result==true && $this->mymodel->add('company',$data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('company_message','Your company has added');
            redirect("auth/user/company");
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['com_name'] = array(

                'name'  => 'com_name',
                'id'    => 'com_name',
                'type'  => 'text',
                'placeholder'=>'Please enter Your company name',
                'value' => $this->form_validation->set_value('com_name'),
            );


            $this->data['email'] = array(

                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'placeholder'=>'example@mail.com',
                'value' => $this->form_validation->set_value('email'),
            );
            $this->data['address'] = array(

                'name'  => 'address',
                'id'    => 'address',
                'type'  => 'text',
                'placeholder'=>'Please enter Your company address',
                'value' => $this->form_validation->set_value('address'),
            );
            $this->data['phone'] = array(

                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['color'] = array(

                'name'  => 'bgcolor',
                'id'    => 'bgcolor',
                'type'  => 'color',
                'value' => $this->form_validation->set_value('bgcolor'),
            );
            $this->data['about_com'] = array(

                'name'  => 'about_com',
                'id'    => 'about_com',
                'type'  => 'textarea',
                'placeholder'=>' Description about company',
                'value' => $this->form_validation->set_value('about_com'),
            );
            $this->data['image_upload'] = array(

                'name'  => 'image_upload',
                'id'    => 'image_upload',
                'type'  => 'file',

            );


            $this->_render_page('auth/add_company', $this->data);
        }

    }


    function user($id=NULL)
    {

        $this->data['superadminid']=$this->mymodel->getValue('name','superadmin','groups','id');
        $this->data['options1']=$this->ion_auth->dropdown_array('id','name','company','id<>'.$this->session->userdata("company_id"));
        $this->data['options1']=array_replace($this->data['options1'],array(''=>'All Company'));
        $this->data['options2']=array_replace($this->ion_auth->dropdown_array('id','name','groups','id<>'.$this->data['superadminid']),array(''=>'Access Level'));

        if(isset($_POST['searchbutton']))
        {
            $query="";
            $search=$this->input->post('search');

            $company=$this->input->post('company');

            $accesstype=$this->input->post('accesstype');
            if(empty($search)&&empty($company)&&empty($accesstype))
            {
                $this->session->set_flashdata('error_message', 'Please select anyone');
                redirect('auth/user/user');
            }
            else
            {

                if(!empty($accesstype))
                {
                    $comma="'".$accesstype."'";
                    $query[]='accesstype='.$comma.'';
                }
                if(!empty($company))
                {
                    $comma="'".$company."'";
                    $query[]='company='.$comma.'';
                }
                if(!empty($search))
                {
                    $comma="'".'%'.$search.'%'."'";

                    $query[]="first_name LIKE $comma";


                }

                if(!empty(!empty($accesstype)||!empty($company)||!empty($search)))
                {
                    $where_clause = implode(' and ', $query);

                    $this->data['query']=$this->mymodel->get('users','*',$where_clause);

                }

            }

        }
        else{
            $this->data['query']=$this->usermodel->userlist();
        }



        $this->_render_page('auth/list', $this->data);
    }


    function companylist()
    {

        if(isset($_POST['searchbutton']))
        {
            $query="";
            $search=$this->input->post('search');


            if(empty($search))
            {
                $this->session->set_flashdata('error_message', 'Please select anyone');
                redirect('auth/user/user');
            }
            else
            {


                if(!empty($search))
                {
                    $comma="'".'%'.$search.'%'."'";

                    $query[]="name LIKE $comma";

                    $query[]='id<>'.$this->session->userdata('company_id').'';

                    $where_clause = implode(' and ', $query);

                    $this->data['result']=$this->mymodel->get('company','*',$where_clause);

                }

            }
        }
        else
        {
            $this->data['result'] =  $this->mymodel->get('company','*','id<>'.$this->session->userdata("company_id"));
        }

        $this->_render_page('auth/company_list', $this->data);
    }



    function edit_company($id)
    {

        $this->data['title']='edit_company';
        if (!$this->ion_auth->logged_in())
        {
            redirect('auth', 'refresh');
        }


        $companyinfo=$this->mymodel->get('company','*','id='.$id);
        foreach($companyinfo as $value)
        {

            $name1=$value['name'];
            $address1=$value['address'];
            $contact1=$value['contact'];
            $email1=$value['email'];
            $description1=$value['description'];
            $bgcolor=$value['bgcolor'];
            $imagename=$value['logo_name'];
            $imagepath=$value['logo_path'];
        }



        // validate form input
        $this->form_validation->set_rules('com_name', $this->lang->line('create_company_validation_name_label'), 'required');

        $this->form_validation->set_rules('email', $this->lang->line('create_company_validation_email_label'), 'required|valid_email');

        $this->form_validation->set_rules('phone', $this->lang->line('create_company_validation_phone_label'), 'required|trim');
        $this->form_validation->set_rules('address', $this->lang->line('create_company_validation_address_label'), 'required|trim');
        $this->form_validation->set_rules('bgcolor', $this->lang->line('create_company_validation_color_label'), 'required|trim');


        //

        if ($this->form_validation->run($this) == true)
        {
            $result=true;
            if($_FILES["image_upload"]["size"]>0)
            {

                $folder_file=$this->input->post('com_name');
                $target='upload';
                $thumb=array('dest' =>$target.'/'.$folder_file,'size' => array('w' => 257,'h' =>218), 'ratio' => true);
                $result=upload_image('image_upload',$target,$thumb, $folder_file);

            }else
            {
                $result=array();
                $result['fullname']=$imagename;
                $result['thumb_dest']=$imagepath;


            }


            if($result)
            {

                $data = array(
                    'name' => $this->input->post('com_name'),
                    'email'=>$this->input->post('email'),
                    'address'=>$this->input->post('address'),
                    'contact'=>$this->input->post('phone'),
                    'description'=>$this->input->post('about_com'),
                    'bgcolor'=>$this->input->post('bgcolor'),
                    'logo_name'=>$result['fullname'],
                    'logo_path'=>$result['thumb_dest']);


            }

        }


        if ($this->form_validation->run() == true && $result==true && $this->mymodel->edit('company',$data,'id',$id)==True)
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('company_message','Your company information  has updated');

            redirect('auth/user/edit_company/'.$id);
        }
        else
        {
            // display the create user form
            $this->data['csrf'] = $this->_get_csrf_nonce();
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['com_name'] = array(

                'name'  => 'com_name',
                'id'    => 'com_name',
                'type'  => 'text',
                'placeholder'=>'Please enter Your company name',
                'value' => $this->form_validation->set_value('com_name',$name1),
            );


            $this->data['email'] = array(

                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'placeholder'=>'example@mail.com',
                'value' => $this->form_validation->set_value('email',$email1),
            );
            $this->data['address'] = array(

                'name'  => 'address',
                'id'    => 'address',
                'type'  => 'text',
                'placeholder'=>'Please enter Your company address',
                'value' => $this->form_validation->set_value('address',$address1),
            );
            $this->data['phone'] = array(

                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('phone',$contact1),
            );
            $this->data['color'] = array(

                'name'  => 'bgcolor',
                'id'    => 'bgcolor',
                'type'  => 'color',
                'value' => $this->form_validation->set_value('bgcolor',$bgcolor),
            );
            $this->data['about_com'] = array(

                'name'  => 'about_com',
                'id'    => 'about_com',
                'type'  => 'textarea',
                'placeholder'=>' Description about company',
                'value' => $this->form_validation->set_value('about_com',$description1),
            );
            $this->data['image_upload'] = array(

                'name'  => 'image_upload',
                'id'    => 'image_upload',
                'type'  => 'file',


            );

            $this->data['id']=$id;
            $this->data['imagename']=$imagename;
            $this->data['imagepath']=$imagepath;



            $this->_render_page('auth/edit_company', $this->data);
        }


    }

    function view_company($id=false)
    {
        $id||$id=$this->session->userdata('company_id');
        $this->data['companyinfo']=$this->mymodel->get('company','*','id='.$id,'','',true);

        $this->_render_page('auth/company', $this->data);
    }

    function delete($type,$id)
    {
        if($type=='company')
        {
            $comname=$this->mymodel->getValue('id',$id,'company','name');


            $this->mymodel->Deletefolder('./upload/'.$comname);

            $this->mymodel->delete('company','id',$id);
            redirect('auth/user/companylist','refresh');

        }
        elseif($type=='users')
        {
            $imagepath=$this->mymodel->getValue('id',$id,'users','image_path');
            $this->mymodel->delete('users','id',$id);
            unlink($imagepath);
            redirect('auth/user/user','refresh');
        }



    }


    function change_password($id=false)
    {
        $id||$id=$this->session->userdata('user_id');
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');


        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }


        $this->data['user'] = $this->ion_auth->user($id)->row();
        if ($this->form_validation->run() == false)
        {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(

                'name' => 'old',
                'id'   => 'old',
                'type' => 'password'
            );
            $this->data['new_password'] = array(

                'name'    => 'new',
                'id'      => 'new',
                'type'    => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$'
            );
            $this->data['new_password_confirm'] = array(

                'name'    => 'new_confirm',
                'id'      => 'new_confirm',
                'type'    => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['user_id'] = array(
                'name'  => 'user_id',
                'id'    => 'user_id',
                'type'  => 'hidden',
                'value' => $this->data['user']->id,
            );

            // render
            $this->_render_page('auth/change_password', $this->data);
        }
        else
        {

            $identity = $this->data['user']->email;



            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect('auth/user/change_password');
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('auth/user/change_password');
            }
        }
    }



} 