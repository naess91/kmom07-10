<?php

namespace Anax\Comments;

/**
 * To attach comments-flow to a page or some content.
 *
 */
class CommentController implements \Anax\DI\IInjectionAware
{
    use \Anax\DI\TInjectable;

    
    
    public function initialize()
    {
        $this->comments = new \Anax\Comments\Comment();
        $this->comments->setDI($this->di);
    }
    /**
     * View all comments.
     *
     * @return void
     */
    public function viewAction()
    {
        $comments = $this->comments->findAll();

        $this->views->add('comment/comments', [
            'comments' => $comments
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
            'name' => [ 
                'type'        => 'text', 
                'label'       => 'Namn:', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'class' => 'form-control'
            ], 
            'homepage' => [ 
                'type'        => 'text', 
                'label'       => 'Hemsida:', 
                'required'    => false, 
                'validation'  => ['not_empty'],
               	'class' => 'form-control'
            ], 
			
			'email' => [ 
                'type'        => 'text', 
                'label'       => 'Mail:', 
                'required'    => false, 
                'validation'  => ['not_empty'],
                'class' => 'form-control'
            ], 
            'content' => [ 
                'type'        => 'textarea', 
                'label'       => 'Text', 
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
              
                    $this->comments->save([ 
                        'name'     => $form->Value('name'), 
                        'homepage'     => $form->Value('homepage'), 
						'email'     => $form->Value('email'), 
                        'content'         => $form->Value('content'), 
                        'timestamp'     => $now, 

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

        $comment = $this->comments->find($id); 

        $form = $form->create([
         'class' => 'comment-form',
            ], [ 
            'name' => [ 
                'type'        => 'text', 
                'label'       => 'Name', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'value' => $comment->name, 
                 'class' => 'form-control'
            ], 
            'homepage' => [ 
                'type'        => 'text', 
                'required'    => false, 
                'validation'  => ['not_empty'], 
                'value' => $comment->homepage, 
                 'class' => 'form-control'
            ], 
			
			'email' => [ 
                'type'        => 'text', 
                'label'       => 'Mail:', 
                'required'    => false, 
                'validation'  => ['not_empty'],
                 'value' => $comment->email,
                'class' => 'form-control'
            ], 
			
            'content' => [ 
                'type'        => 'textarea', 
                'required'    => true, 
                'validation'  => ['not_empty'], 
                'value' => $comment->content, 
                 'class' => 'form-control'
            ], 
            'submit' => [ 
                'type'      => 'submit', 
                 'class' => 'commentButton',
                 'value' => 'Spara',
                'callback'  => function($form) use ($comment) { 

                    $now = date("Y-m-d H:i:s");

                    $this->comments->save([ 
                        'id'        => $comment->id,  
                        'name'         => $form->Value('name'),
                        'homepage' => $form->Value('homepage'),
						'email' => $form->Value('email'),
                        'content' => $form->Value('content'),
                        'timestamp' => $now,
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
        $this->views->add('comment/edit', [ 
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