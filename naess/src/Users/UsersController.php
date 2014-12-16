<?php  

namespace Anax\Users;  
   
/**  
 * A controller for users and admin related events.  
 *  
 */  
class UsersController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;
		use \Anax\MVC\TRedirectHelpers;
		
		/**
		 * Initialize the controller.
		 *
		 * @return void
		 */
	public function initialize()
		{
			$this->session();
		    $this->users = new \Anax\Users\User();
		    $this->users->setDI($this->di);
				
			$this->answers = new \Anax\Answers\Answers();  
			$this->answers->setDI($this->di);
					
        	$this->questions = new \Anax\Questions\Questions();  
        	$this->questions->setDI($this->di);
				
			$this->comments = new \Anax\Comments\Comments();
			$this->comments->setDI($this->di);
				
			$this->taglist = new \Anax\Tags\Tagslist();
			$this->taglist->setDI($this->di);
				
			$this->tags = new \Anax\Tags\Tags();
			$this->tags->setDI($this->di);
			
			$this->db = new \Anax\Database\CDatabaseModel();
			$this->db->setDI($this->di);
			
			

		}
		
		public function registerAction() {
		$this->initialize();
      	$form = $this->form->create([], [ 
        'acronym' => [ 
            'type'        => 'text', 
            'label'       => 'Användarnamn: ', 
            'required'    => true, 
            'validation'  => ['not_empty'], 
        ], 
				
          'name' => [ 
              'type'        => 'text', 
              'label'       => 'Namn:', 
              'required'    => true, 
              'validation'  => ['not_empty'], 
          ], 
       
          'email' => [ 
              'type'        => 'text', 
              'required'    => true, 
              'validation'  => ['not_empty', 'email_adress'], 
          ],
          'password' => [ 
              'type'        => 'password', 
							'label'       => 'Lösenord:', 
              'required'    => true, 
              'validation'  => ['not_empty'], 
          ], 
          'passwordagain' => [ 
              'type'        => 'password',
							'label'       => 'Ange Lösenord igen:',  
              'required'    => true, 
              'validation'  => ['not_empty'],
          ], 
          'submit' => [ 
              'type'      => 'submit', 
              'callback'  => function($form){ 
                $now = date("Y-m-d H:i:s");
				$acronym = $form->Value('acronym');
				$taken = $this->users->query()
							  ->where("acronym = '$acronym'")
							  ->execute();
		if(empty($taken) && ($form->Value('password') == $form->Value('passwordagain'))) {
	            $this->users->save([ 
	            'name'     => $form->Value('name'), 
	            'email'     => $form->Value('email'), 
				'acronym' => $form->Value('acronym'),
				'password' => password_hash($form->Value('password'), PASSWORD_DEFAULT),
				'created' => $now
				 ]);
				return true; 
				}
				else {
				return false;
				}
                 } 
          ], 
      ]); 
      // Check the status of the form 
      $status = $form->check(); 
      if ($status === true) { 
          $this->redirectTo($this->url->create('users/login/success'));
   
      } else if ($status === false) {
					$form->AddOutput("Användarnamn upptaget eller lösenord ej korrekt");
					$this->redirectTo();
      } 
      $this->theme->setTitle("Registrera användare"); 
      $this->views->add('users/edit', [ 
          'title' => "Registrera användare", 
          'form' => $form->getHTML() 
      ]); 
		}
		
		public function changePasswordAction($acronym = null)
		{
			$this->initialize();
	    	$user = $this->users->query()
						 ->where("acronym = '$acronym'")
						 ->execute();
			
			$user = $user[0];
      		$form = $this->form->create([], [ 
          	  'oldpassword' => [ 
              'type'        => 'password', 
              'label'       => 'Gamla lösenordet', 
              'required'    => true, 
              'validation'  => ['not_empty'], 
          ], 
          'newpassword' => [ 
              'type'        => 'password', 
              'label'       => 'Nytt lösenord:', 
              'required'    => true, 
              'validation'  => ['not_empty'], 
          ], 
          'newpasswordagain' => [ 
              'type'        => 'password', 
              'required'    => true, 
              'validation'  => ['not_empty'], 
          ], 
          'submit' => [ 
              'type'      => 'submit', 
              'callback'  => function($form) use ($user) { 
		if(password_verify($form->Value('oldpassword'), $user->password) && $form->Value('newpassword') == $form->Value('newpasswordagain')){
                  
		$this->users->save([ 
                      'id'        => $user->id, 
                      'password'     => password_hash($form->Value('newpassword'), PASSWORD_DEFAULT)
                  ]); 
									return true; 
								}
								else {
									return false;
								}
                  
              } 
          ], 
      ]); 
      // Check the status of the form 
      $status = $form->check(); 
      if ($status === true) { 
          $this->response->redirect($this->url->create('minsida'));  
   
      } else if ($status === false) { 
					$form->AddOutput("Lösenorden matchade inte");
          $this->redirectTo();
      } 
      $this->theme->setTitle("Redigera användare"); 
      $this->views->add('users/edit', [ 
          'title' => "Redigera användare", 
          'form' => $form->getHTML() 
      ]); 
		}
		
		
		
		/**
		 * List all users.
		 *
		 * @return void
		 */
		public function listAction()
		{
		    $this->initialize();
 
		    $all = $this->users->findAll();
 
		    $this->theme->setTitle("Alla användare");
		    $this->views->add('users/list-all', [
		        'users' => $all,
		        'title' => "Alla användare",
		    ]);
		}
		
		public function statusAction()
		{
	    $this->initialize();
		$acronym = $_SESSION['user'];
	   $user = $this->users->query()
				->where("acronym = '$acronym'")
				->execute();
										 
						 
				
				$user = $user[0];
				
				$questions = $this->questions->query()
				 ->where("user = '$acronym'")
				 ->execute();
				
				$answers = $this->answers->query()
				 ->where("user = '$acronym'")
				 ->execute();
				 
				
				 
			
				
				foreach($answers as $answer) {
					$ids[] = $answer->question;
				}
				
		
				if (!empty($ids)) {
					$string = "";
				
					$ids = array_unique($ids);
					
					$answers = array();
			foreach ($ids as $id) {
					$answers[] = $this->questions->query()
									  ->where("id = $id")
									  ->execute();
				}
				}
				else { }
				
 
		    $this->theme->setTitle("View user with id");
		    $this->views->add('users/view', [
		        		'user' => $user,
						'questions' => $questions,
						
						'answers' => $answers
 		    ]);
				
						
		}
		
		public function logoutAction()
		{
			$user = $_SESSION['user'];
	    $this->initialize();
			unset($_SESSION['user']);
			$this->theme->setTitle("Utloggad");
	    $this->views->add('users/logout', [
	        'user' => $user,
	    ]);	
			
		}
		
		public function loginAction($message = null)
		{
			$this->theme->setTitle("Profil");
		    $this->initialize();
		    $form = $this->form->create([], [
		        'acronym' => [
		            'type'        => 'text',
		            'label'       => 'Användarnamn:',
		            'required'    => true,
		            'validation'  => ['not_empty'],
		        ],
		        'password' => [
		            'type'        => 'password',
		            'required'    => true,
		            'validation'  => ['not_empty'],
		        ],
						
		        'Submit' => [
		            'type'      => 'submit',
					'class'		=> 'submit',	
					
		            'callback'  => function ($form) {
		          
		                return true;
		            }
		        ],
		       
		    ]);
			  // Check the status of the form
			     $status = $form->check();
 
			     if ($status === true) {
 
						 $acronym = $form->Value('acronym');
						 $password = $form->Value('password');
						 $user = $this->users->query()
							 				 ->where("acronym = '$acronym'")
											 ->execute();
								
			       
						 if(empty($user)) {
						 		$form->AddOutput("Användarnamn eller lösenord är fel.");
								$this->redirectTo();
						 }
						 else {
							 if(password_verify($password, $user[0]->password)) {
								 $_SESSION['user'] = $user[0]->acronym;
								 $this->redirectTo();
								 $url = $this->url->create('questions');
        $this->response->redirect($url);
							 }
							 else {
							 		$form->AddOutput("Användarnamn eller lösenord är fel.");
									$this->redirectTo();
							 }
						 }
 
			     } else if ($status === false) {
			         $this->response->redirect($this->request->getCurrentUrl());
			     }
					 
			     $this->views->add('users/login', [
			         'title' => "Logga in",
					 'message' => $message,
			         'content' => $form->getHTML()
			     ]);
		}
		
		public function idAction($acronym = null)
		{
		    $this->initialize();
 
		    $user = $this->users->query()
						 ->where("acronym = '$acronym'")
						 ->execute();
				
		    $user = $user[0];
				
		    $questions = $this->questions->query()
				 			  ->where("user = '$acronym'")
				 			  ->execute();
				
			$answers = $this->answers->query()
				            ->where("user = '$acronym'")
				 			->execute();
			
			foreach($answers as $answer) {
					$ids[] = $answer->question;
				}
				
				if (!empty($ids)) {
					$string = "";
				
					$ids = array_unique($ids);
					
					$answers = array();
			foreach ($ids as $id) {
					$answers[] = $this->questions->query()
									  ->where("id = $id")
									  ->execute();
				}
				}
				else { echo "hej";}
				
 
		    $this->theme->setTitle("View user with id");
		    $this->views->add('users/view', [
		        		'user' => $user,
						'questions' => $questions,
						
						'answers' => $answers
 		    ]);
				
				
		}
		
	
		public function addAction($acronym = null)
		{
		    if (!isset($acronym))  {
		        die("Missing acronym");
		    }
 
		    $now = date("Y-m-d H:i:s");
 
		    $this->users->save([
		        'acronym' => $acronym,
		        'email' => $acronym . '@mail.se',
		        'name' => 'Mr/Mrs ' . $acronym,
		        'password' => password_hash($acronym, PASSWORD_DEFAULT),
		        'created' => $now,
		        'active' => $now,
		    ]);
 
		    $url = $this->url->create('users/id/' . $this->users->id);
		    $this->response->redirect($url);
		}
		
	
		    public function editAction($acronym = null)  
		    {  
						$this->initialize();
				    $user = $this->users->query()
												 ->where("acronym = '$acronym'")
												 ->execute();
						
					$user = $user[0];
		        	$form = $this->form->create([], [ 
		            'name' => [ 
		                'type'        => 'text', 
		                'label'       => 'Namn', 
		                'required'    => true, 
		                'validation'  => ['not_empty'], 
		                'value' => $user->name, 
		            ], 
		          
		            'email' => [ 
		                'type'        => 'text', 
		                'required'    => true, 
		                'validation'  => ['not_empty', 'email_adress'], 
		                'value' => $user->email, 
		            ], 
					
					 'image' => [ 
		                'type'        => 'text', 
						'label'       => 'Bild (bildwebbadress)', 
		                'required'    => false, 
		              
		                'value' => $user->image, 
		            ], 
					
		            'submit' => [ 
		                'type'      => 'submit', 
		                'callback'  => function($form) use ($user) { 
		                  	  	$now = date(DATE_RFC2822); 
		                   		$this->users->save([ 
		                        'id'        => $user->id, 
		                        'name'     => $form->Value('name'), 
		                        'email'     => $form->Value('email'), 
								'image'     => $form->Value('image'), 
		                      
		                    ]); 
		                    return true; 
		                } 
		            ], 
		        ]); 
		       
		        $status = $form->check(); 
		        if ($status === true) { 
		            
          $this->response->redirect($this->url->create('profile'));  
		        } else if ($status === false) { 
		            $form->AddOutput("Lösenorden stämde inte");
          $this->redirectTo();
		        } 
		        $this->theme->setTitle("Redigera användare"); 
		        $this->views->add('users/edit', [ 
		            'title' => "Redigera användare", 
		            'form' => $form->getHTML() 
		        ]); 
		    }  
		
		
		public function deleteAction($id = null)
		{
				$this->initialize();
				
		    if (!isset($id)) {
		        die("Missing id");
		    }
 
		    $res = $this->users->delete($id);
 
		    $url = $this->url->create('users/list');
		    $this->response->redirect($url);
		}
		
	
		public function softDeleteAction($id = null)
		{
				$this->initialize();
				
		    if (!isset($id)) {
		        die("Missing id");
		    }
 
		    $now = date("Y-m-d H:i:s");
 
		    $user = $this->users->find($id);
				
				if(is_null($user[0]->deleted)) {
			    $user[0]->deleted = $now;
			    $this->users->save($user[0]);
				}
 			 	else {
			    $user[0]->deleted = null;
			    $this->users->save($user[0]);
 			 	}
		    
 
		    $url = $this->url->create('users/id/' . $id);
		    $this->response->redirect($url);
		}
		
		public function activateAction($id = null)
		{
				$this->initialize();
				
		    if (!isset($id)) {
		        die("Missing id");
		    }
 
		    $now = date(DATE_RFC2822);
 
		    $user = $this->users->find($id);
				
				if(is_null($user[0]->active)) {
			    $user[0]->active = $now;
			    $this->users->save($user[0]);
				}
 			 	else {
			    $user[0]->active = null;
			    $this->users->save($user[0]);
 			 	}
		    
 
		    $url = $this->url->create('users/id/' . $id);
		    $this->response->redirect($url);
		}
		
		/**
		 * List all active and not deleted users.
		 *
		 * @return void
		 */
		public function activeAction()
		{
		    $all = $this->users->query()
		        ->where('active IS NOT NULL')
		        ->andWhere('deleted is NULL')
		        ->execute();
 
		    $this->theme->setTitle("Users that are active");
		    $this->views->add('users/list-all', [
		        'users' => $all,
		        'title' => "Aktiva användare",
		    ]);
		}
		
		public function inActiveAction()
		{
		    $all = $this->users->query()
		        ->where('active IS NULL')
		        ->andWhere('deleted is NULL')
		        ->execute();
 
		    $this->theme->setTitle("Inaktiva användare");
		    $this->views->add('users/list-all', [
		        'users' => $all,
		        'title' => "Inaktiva användare",
		    ]);
		}
		
		public function trashAction()
		{
		    $all = $this->users->query()
		        ->where('deleted IS NOT NULL')
		        ->execute();
 
		    $this->theme->setTitle("Papperskorgen");
		    $this->views->add('users/list-all', [
		        'users' => $all,
		        'title' => "Papperskorgen",
		    ]);
		}
 
}

