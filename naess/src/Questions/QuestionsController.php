<?php  
namespace Anax\Questions;  
class QuestionsController implements \Anax\DI\IInjectionAware  
{  
    use \Anax\DI\TInjectable;  
		use \Anax\MVC\TRedirectHelpers;
      
    public function initialize()  
    { 
				$this->session();
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
	
 
    public function addAction()  
    {  
		$this->session();
				
		$this->theme->setTitle("Ställ en fråga");
        
		if(!isset($_SESSION['user']))  
        {  
          $this->response->redirect($this->url->create('profile'));  
        }  
				
		$form = $this->form->create([], [
		        'title' => [
		            'type'        => 'text',
		            'label'       => 'Titel:',
		            'required'    => true,
		            'validation'  => ['not_empty'],
		        ],
				
				 'taggar' => [
		            'type'        => 'text',
					'label'				=> 'Taggar(Använd mellanslag om du vill använda mer än en tagg):',
		            'required'    => true,
		            'validation'  => ['not_empty'],
		        ],
						
		        'content' => [
		            'type'        => 'textarea',
					'label'				=> 'Fråga:',
		            'required'    => true,
		            'validation'  => ['not_empty'],
		        ],
		       
						
		        'submit' => [
		            'type'      => 'submit',
		            'callback'  => function ($form) {
		            
		                return true;
		            }
		        ],
		       
		    ]);
			  // Check the status of the form
			     $status = $form->check();
 
			     if ($status === true) {
						 $now = date("Y-m-d H:i:s");
		         		 $this->questions->save([  
		                 'content'   => $this->textFilter->doFilter($this->request->getPost('content'), 'shortcode, markdown'),  
		                 'user'      => $_SESSION['user'],   
		                 'title' => $this->request->getPost('title'),
						 'created' => $now
		         ]);
								 $linkid = $this->questions->lastInsertId();
								 $tags = explode(" ", $this->request->getPost('tags'));
								 foreach($tags as $tag){
					         $this->tags->create([  
					             'tag'      => $tag,   
					             'linkid' => $linkid
					         ]);
								 }
								 $this->redirectTo($this->url->create('questions/view/' . $linkid));
						
			     } else if ($status === false) {
						 	$form->AddOutput("Fyll i samtliga fält.");
			     }
					 
			     $this->views->add('default/page', [
			         'title' => "Ställ en fråga",
			         'content' => $form->getHTML()
			     ]);  
    }  
	
	public function addCommentAction() {
			
					$now = date("Y-m-d H:i:s");
      				$this->comments->save([  
          			'content'   => $this->request->getPost('content'),  
          			'user'      => $this->request->getPost('user'),   
          			'linkid' => $this->request->getPost('linkid'),
					'type' => $this->request->getPost('type'),
					'questionid' => $this->request->getPost('questionid'),
					'comment' => $this->request->getPost('comment'),
					'created' => $now
      ]); 
				$this->redirectTo($this->url->create('questions/view/' . $this->request->getPost('redirect')));
		}
		
    public function listAction($tag = null)  
    { 
			if(isset($tag)) {
				
				$allQuestions = $this->taglist->query()
									->where("tags LIKE '%$tag%'")
									->execute();
				$title = "Frågor som innehåller ($tag)";
				
			
			}
			else {
	     		$allQuestions = $this->taglist->findAll();
	
				$title = "Alla Frågor";
				}
			
				$allQuestions = isset($allQuestions) ? $allQuestions : [];
      			$this->views->add('post/list-all', [   
              					'questions' => $allQuestions,
								'title' => $title,
								]);
      }  
		
    public function latestAction($tag = null)  
    { 
	    $questions = $this->questions->query()
				->orderBy("created DESC")
				->execute();
				
		$title = "Senaste frågorna";
			
		$questions = isset($questions) ? $questions : [];
        $this->views->add('post/list-latest', [   
              'questions' => $questions,
			  'title' => $title,
      ]);
      
      
    } 
	
	 public function activityAction($tag = null)  
    { 
	   		$questions = $this->db->latestActivity();
				
			$title = "Senaste aktiviteten";
			
			$questions = isset($questions) ? $questions : [];
      		$this->views->add('post/list-activity', [   
              'questions' => $questions,
			  'title' => $title,
      ]);
      
      
    } 
	public function totalQuestionsAction($tag = null)  
    { 
	   		$questions = $this->db->totalQuestions();
				
			$title = "Totalt antal frågor";
			
			$questions = isset($questions) ? $questions : [];
      		$this->views->add('post/list-count', [   
              				'questions' => $questions,
							'title' => $title,
      ]);
      
      
    } 
		
    public function populartagsAction($tag = null)  
    { 
	    	$taglist = $this->db->topTags();
			$title = "Populära tags";
			
			$questions = isset($questions) ? $questions : [];
     		$this->views->add('post/list-alltags', [   
              				'taglist' => $taglist,
							'title' => $title,
      ]);
      
      
    } 
    public function removeAction($id = null)  
    {  
        if (!isset($id)) {  
            die("Missing id");  
        }  
        $this->questions->delete($id);  
        $this->response->redirect($this->request->getPost('redirect'));  
    }
		
	public function listTagsAction(){
			$title = "Alla taggar";
      $taglist = $this->db->distinct();
			
      $this->views->add('post/list-alltags', [   
              'taglist' => $taglist,
							'title' => $title
      ]); 
		}
    
   public function editAction($id = null)  
    {  
        if(!isset($id)) {  
            die("Missing id");  
        }  
        $question = $this->questions->find($id);  
        $this->views->add('question/edit', [  
						'content' => $question[0]->content,
						'page' => $question[0]->page,
						'name' => $question[0]->name,
						'web' => $question[0]->web,
						'id' => $question[0]->id,
						'mail' => $question[0]->mail,
        ]);  
    }  
    public function saveAction()  
    {  
        if(!$this->request->getPost('doSubmit'))  
        {  
            $this->response->redirect($this->request->getPost('redirect'));      
        }  
        $question = $this->questions->find($this->request->getPost('id'));
				$question = $question[0];
        $question->name = $this->request->getPost('name');  
        $question->mail = $this->request->getPost('mail');  
        $question->web = $this->request->getPost('web');  
        $question->content = $this->request->getPost('content');  
        $question->updated = date(DATE_RFC2822);  
        $question->timestamp = date(DATE_RFC2822); 
        $this->questions->save($question);  
        $this->response->redirect($this->url->create(''));  
    }  
		
   public function viewAction($id = null)  
    	{  
			$this->session();
      if(!isset($id)) {  
          die("Missing id");  
    	}
	  		
			$answers = array();
			$answerlist = $this->answers->query()
							   ->where("question = '$id'")
							   ->execute();
			
			foreach($answerlist as $answer) {
				
				$answer = $answer->getProperties();
				
				$comments = $this->comments->query()
								 ->where("comment = 'answer'")
								 ->andWhere("linkid =" . $answer['id'])
								 ->execute();
								 
				$answer['comments'] = array();
				foreach($comments as $comment) {
					$answer['comments'][] = $comment;
				}
				
				$answers[] = $answer;
			}
			
	    $form = $this->form->create([], [
	        'content' => [
	            'type'        => 'textarea',
	            'label'       => '',
	            'validation'  => ['not_empty'],
	        ],
	        'submit' => [
	            'type'      => 'submit',
	            'callback'  => function ($form) {
	                return true;
	            }
	        ],
	       
	    ]);
		  // Check the status of the form
		     $status = $form->check();
		     if ($status === true) {
					 $now = date("Y-m-d H:i:s");
	         $this->answers->save([  
	             'content'   => $this->textFilter->doFilter($this->request->getPost('content'), 'shortcode, markdown'),  
	             'user'      => $_SESSION['user'],   
	             'question' => $id,
				 'type' => 'Svar',
				 'created' => $now
	         ]); 
				$this->redirectTo($this->url->create('questions/view/' . $id));
					
		     } else if ($status === false) {
					 	
		     }
			
			
      	$question = $this->questions->find($id);
	  	$tags =  $this->tags->query()
					  ->where("linkid = '$id'")
					  ->execute();
	   
			$comment = $this->comments->query()
							->where("comment = 'question'")
							->andWhere("linkid =" . $id)
							->execute();
			
		$this->theme->setTitle("Frågor");	
			
      $this->views->add('post/view', [   
	  			'tags' => $tags,
                'question' => $question,
				'comments' => $comment,
				'answers' => $answers,
				'form'  => $form->getHTML()
							
      ]);  
    }  
}   