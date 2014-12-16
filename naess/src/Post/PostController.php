<?php

namespace Anax\Post;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class PostController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    
    
    public function initialize()
    {
        $this->posts = new \Anax\Post\Posts();
        $this->posts->setDI($this->di);
    }
    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction()
    {
        $question = $this->posts->findAll();

        $this->views->add('post/comments', [
            'comments' => $question
        ]);
    }
	
	    public function idAction($id = null)  
    {  
        $this->initialize();  
       
        $posts = $this->posts->find($id);  
       
        $this->theme->setTitle("Användare");  
        $this->views->add('post/view', [  
            'posts' => $posts,  
        ]);  
    }  
    
    public function cancelAction(){
        $this->response->redirect($this->request->getPost('redirect'));
    }
 
    
   

 
     public function deleteAction($id){
     
         

        $this->comments->delete($id);  

           $url = $this->url->create('report');
        $this->response->redirect($url);
     }
     
     
     public function addCommentAction()  
    { 
       

        $form = $this->form->create([
         'class' => 'comment-form'
            ], [ 
            'title' => [ 
                'type'        => 'text', 
                'label'       => 'Titel:', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'class' => 'form-control'
            ], 
           
            'content' => [ 
                'type'        => 'textarea', 
                'label'       => 'Kommentar', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'class' => 'form-control'
            ], 
            'submit' => [ 
                'type'      => 'submit', 
                'class' => 'commentButton',
                'value' => 'Kommentera',
                'callback'  => function($form) { 

                    $now = date("Y-m-d H:i:s");
					
					$this->posts->save([ 
                        'title'     => $form->Value('title'), 
                        'content'         => $form->Value('content'), 
                        'created'     => $now, 

                    ]); 
              
                    $this->posts->save([ 
                        'title'     => $form->Value('title'), 
                        'content'         => $form->Value('content'), 
                        'created'     => $now, 

                    ]); 

                    return true; 
                } 
            ],

        ]); 

        // Check the status of the form 
        $status = $form->check(); 

        if ($status === true) { 
          
            $url = $this->url->create('report'); 
            $this->response->redirect($url); 
         
        } else if ($status === false) { 
         
            // What to do when form could not be processed? 
            $form->AddOutput("<p><i>Form was submitted and the Check() method returned false.</i></p>"); 
            header("Location: " . $_SERVER['PHP_SELF']); 
        } 

     
        $this->views->add('comment/edit', [ 
            
            'form' => $form->getHTML() 
        ]); 
    }
    /**
     * Remove all comments.
     *
     * @return void
     */
  
     
          public function editAction($id = null)  
    {  
        $form = $this->form; 

        $posts = $this->posts->find($id); 

        $form = $form->create([
         'class' => 'comment-form',
            ], [ 
            'title' => [ 
                'type'        => 'text', 
                'label'       => 'Titel', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'value' => $posts->title, 
                 'class' => 'form-control'
            ], 
           
			
            'content' => [ 
                'type'        => 'textarea', 
				 'label'       => 'Kommentar',
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'value' => $posts->content, 
                 'class' => 'form-control'
            ], 
            'submit' => [ 
                'type'      => 'submit', 
                 'class' => 'commentButton',
                 'value' => 'Spara',
                'callback'  => function($form) use ($posts) { 

                    $now = date("Y-m-d H:i:s");

                    $this->posts->save([ 
                        'id'        => $posts->id,  
                        'title'         => $form->Value('title'),
                        'content' => $form->Value('content'),
                     
                    ]); 

                    return true; 
                } 
            ], 

        ]); 

        // Check the status of the form 
        $status = $form->check(); 

        if ($status === true) { 
            $url = $this->url->create('report'); 
            $this->response->redirect($url); 
         
        } else if ($status === false) { 
            header("Location: " . $_SERVER['PHP_SELF']); 
            exit; 
        } 

        $this->theme->setTitle("Update comment"); 
        $this->views->add('post/edit', [ 
            'title' => "Update comment", 
            'form' => $form->getHTML() 
        ]); 

    }
    public function removeAllAction()
    {
        $isPosted = $this->request->getPost('removeAll');
        
        if (!$isPosted) {
            $this->response->redirect($this->request->getPost('redirect'));
        }

        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);
        
        $key =  $this->request->getPost('key');
        $comments->deleteAll($key);

        $this->response->redirect($this->request->getPost('redirect'));
    }
    
    public function removePostAction($id) 
    {
        $isPosted = $this->request->getPost('removePost');
        
        if(!$isPosted){
            $this->response->redirect($this->request->getPost('redirect'));
        }
        
        $comments = new \Phpmvc\Comment\CommentsInSession();
        $comments->setDI($this->di);
        $key = $this->request->getPost('key');
        $comments->deleteComment($id, $key);
        $this->response->redirect($this->request->getPost('redirect'));
    }
    
    
    

}