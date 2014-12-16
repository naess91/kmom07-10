<?php 
namespace Anax\Users;
 
/**
 * A controller for users and admin related events.
 *
 */
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
 
    public function initialize()
    {
        $this->users = new \Anax\Users\User();
        $this->users->setDI($this->di);
    }
    
      public function listAction()
        {
          
         
            $all = $this->users->findAll();
         
            $this->theme->setTitle("List all users");
            $this->views->add('users/list-all', [
                'users' => $all,
                'title' => "<h3><i class='fa fa-users'></i> Users found in our database</h3>",
            ]);
        }
        
        
    public function idAction($id = null)
    {    
     
        $user = $this->users->find($id);
     
        $this->theme->setTitle("View user with id");
        $this->views->add('users/view', [
            'user' => $user,
        ]);
    }
    
   public function addAction()  
    { 
        $form = $this->form; 

        $form = $form->create([], [ 
            'acronym' => [ 
                'type'        => 'text', 
                'label'       => 'Acronym', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'class' => 'form-control',
            ], 
            'password' => [ 
                'type'        => 'password', 
                'label'       => 'Password', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                    'class' => 'form-control',
            ], 
            'name' => [ 
                'type'        => 'text', 
                'label'       => 'Name', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                    'class' => 'form-control',
            ], 
            'email' => [ 
                'type'        => 'text', 
                'required'    => true, 
                'validation'  => ['not_empty', 'email_adress'], 
                    'class' => 'form-control',
            ], 
            'submit' => [ 
                'type'      => 'submit', 
                'class' => 'btn btn-lg btn-success pull-right',
                'Value' => 'Add',
                'callback'  => function($form) { 

                    $now = date("Y-m-d H:i:s"); 
              
                    $this->users->save([ 
                        'acronym'     => $form->Value('acronym'), 
                        'email'     => $form->Value('email'), 
                        'name'         => $form->Value('name'), 
                        'password'     => password_hash($form->Value('password'), PASSWORD_BCRYPT), 
                        'created'     => $now, 
                        'active'     => $now, 
                    ]); 

                    return true; 
                } 
            ], 

        ]); 

        // Check the status of the form 
        $status = $form->check(); 

        if ($status === true) { 
          
            $url = $this->url->create('users/id/' . $this->users->id); 
            $this->response->redirect($url); 
         
        } else if ($status === false) { 
         
            // What to do when form could not be processed? 
            $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>"); 
            header("Location: " . $_SERVER['PHP_SELF']); 
        } 

        $this->theme->setTitle("Lägg till användare"); 
        $this->views->add('users/add', [ 
            'title' => "<h3><i class='fa fa-plus-square'></i> Add a new user</h3>", 
            'form' => $form->getHTML() 
        ]); 
    }

    public function deleteAction($id = null)
    {
        if (!isset($id)) {
            die("Missing id");
        }
     
        $res = $this->users->delete($id);
     
        $url = $this->url->create('users\list');
        $this->response->redirect($url);
    }
    
     public function editAction($id = null)  
    {  
        $form = $this->form; 

        $user = $this->users->find($id); 

        $form = $form->create([], [ 
            'acronym' => [ 
                'type'        => 'text', 
                'label'       => 'Acronym', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'value' => $user->acronym, 
                'class' => 'form-control'
            ], 
            'name' => [ 
                'type'        => 'text', 
                'label'       => 'Name', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'value' => $user->name, 
                'class' => 'form-control'
            ], 
            'email' => [ 
                'type'        => 'text', 
                'required'    => true, 
                'validation'  => ['not_empty', 'email_adress'], 
                'value' => $user->email, 
                'class' => 'form-control'
            ], 
            'submit' => [ 
                'type'      => 'submit', 
                'class' => 'col-md-offset-11 btn btn-success btn-lg',
                'value' => 'Update',
                'callback'  => function($form) use ($user) { 

                    $now = date("Y-m-d H:i:s");

                    $this->users->save([ 
                        'id'        => $user->id, 
                        'acronym'     => $form->Value('acronym'), 
                        'email'     => $form->Value('email'), 
                        'name'         => $form->Value('name'), 
                        'updated'     => $now, 
                        'active'     => $now, 
                    ]); 

                    return true; 
                } 
            ], 

        ]); 

        // Check the status of the form 
        $status = $form->check(); 

        if ($status === true) { 
            $url = $this->url->create('users/id/' . $user->id); 
            $this->response->redirect($url); 
         
        } else if ($status === false) { 
            header("Location: " . $_SERVER['PHP_SELF']); 
            exit; 
        } 

        $this->theme->setTitle("Uppdatera användare"); 
        $this->views->add('users/update', [ 
            'title' => "Uppdatera användare", 
            'form' => $form->getHTML() 
        ]); 

    }

        public function softDeleteAction($id = null)
        {
            if (!isset($id)) {
                die("Missing id");
            }
         
            $now = date("Y-m-d H:i:s");
         
            $user = $this->users->find($id);
            if(isset($user->deleted))
            {
                $user->deleted = null;
                
            }
            else 
            {
                $user->deleted = $now;
            
            }
            $user->save();
         
            $url = $this->url->create('users/id/' . $id);
            $this->response->redirect($url);
        }

        
        
        public function activateAction($id = null)
        {
            $now = date("Y-m-d H:i:s");
            
            $user = $this->users->find($id);
            if(isset($user->active))
            {
              $user->active = null;
            }
            else 
            {
                $user->active = $now;
            }
            
            $user->save();
            $url = $this->url->create('users/id/' . $id);
            $this->response->redirect($url);
        }
        
        public function activeAction()
        {
            $this->initialize();
            $all = $this->users->query()
                ->where('active IS NOT NULL')
                ->andWhere('deleted is NULL')
                ->execute();
         
            $this->theme->setTitle("Users that are active");
            $this->views->add('users/list-all', [
                'users' => $all,
                'title' => "<h3><i class='fa  fa-users'></i> Active users</h3>",
            ]);
        }
    
        public function inactiveAction()
        {
            $this->initialize();
            $all = $this->users->query()
                ->where('active IS NULL')
                ->andWhere('deleted is NULL')
                ->execute();
         
            $this->theme->setTitle("Users that are inactive");
            $this->views->add('users/list-all', [
                'users' => $all,
                'title' => "<h3><i class='fa  fa-users'></i> Inactive users</h3>",
            ]);
        }
    
    public function trashcanAction() 
{ 
    $all = $this->users->query() 
        ->where('deleted IS NOT NULL') 
        ->execute(); 
  
    $this->theme->setTitle("Papperskorgen"); 
    $this->views->add('users/list-all', [ 
        'users' => $all, 
        'title' => "<h3><i class='fa  fa-trash'></i> Användare i papperskorgen</h3>", 
        'message'=>"", 
    ]); 
     
} 

}    