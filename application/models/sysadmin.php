<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * Class for installation and updates
 */
Class Sysadmin extends CI_Model {
	public $db_version = '0.6';
	function __construct()
	    {
	        // Call the Model constructor
	        parent::__construct();
			$this->load->dbforge();
	    }
	/*
	 * Installation script installs primary tables and initial data if needed.
	 */
	function install()
	{
		/*
		 * Create system info table
		 */
		$fields = array(
			'sysinfo_id' => array(
				'type' => 'INT',
				'constraint' => 6,
				'auto_increment' => TRUE
			),
			'sysinfo_key' => array(
				'type' => 'VARCHAR',
				'constraint' => 255
			),
			'sysinfo_value' => array(
				'type' => 'TEXT'
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('sysinfo_id', TRUE);
		$this->dbforge->create_table('system_info',TRUE);
		/*
		 * Create user table
		 */
		$fields = array(
			'ID' => array(
				'type' => 'BIGINT',
				'constraint' => '11',
				'auto_increment' => TRUE,
			),
			'email' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE,
			),
			'password' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE,
			),
			'firstname' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'lastname' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'avatar' => array(
				'type' => 'TEXT',
			),
			'accesslevel' => array(
				'type' => 'INT',
				'constraint' => '11',
			),
			'group_id' => array(
				'type' => 'BIGINT',
				'constraint' => '11',
			),
			'resetkey' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
			),
			'terms_accepted' => array(
				'type' => 'BIGINT',
				'constraint' => 12,
				'null' => FALSE,
			),
			'dateadded' => array(
				'type' => 'BIGINT',
				'constraint' => 12,
				'null' => FALSE,
			),
			'dateremoved' => array(
				'type' => 'BIGINT',
				'constraint' => 12,
				'null' => FALSE,
			),
			'notes' => array(
				'type' => 'TEXT'
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('user',TRUE);
		/*
		 * Add groups table
		*/
		$fields = array(
				'ID' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'auto_increment' => TRUE,
				),
				'name' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						'null' => FALSE,
				),
				'accesslevel' => array(
						'type' => 'INT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'dateadded' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'dateremoved' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'notes' => array(
						'type' => 'TEXT'
				)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('user_group',TRUE);
		/*
		 * Create organization table
		 */
		$fields = array(
			'ID' => array(
				'type' => 'BIGINT',
				'constraint' => '11',
				'auto_increment' => TRUE,
			),
			'name' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE,
			),
			'slug' => array(
					'type' => 'VARCHAR',
					'constraint' => '255',
					'null' => FALSE,
			),
			'description' => array(
					'type' => 'TEXT'
			),
			'dateadded' => array(
				'type' => 'BIGINT',
				'constraint' => 12,
				'null' => FALSE,
			),		
			'dateremoved' => array(
				'type' => 'BIGINT',
				'constraint' => 12,
				'null' => FALSE,
			),
			'notes' => array(
				'type' => 'TEXT'
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('organization',TRUE);
		/*
		 * Create org_meta table
		 */
		$fields = array(
				'ID' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'auto_increment' => TRUE,
				),
				'org_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'meta_key' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						'null' => FALSE,
				),
				'meta_value' => array(
						'type' => 'TEXT'
				),
				'dateadded' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'dateremoved' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'notes' => array(
						'type' => 'TEXT'
				)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('org_meta',TRUE);
		/*
		 * Create user2org table
		 */
		$fields = array(
				'ID' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'auto_increment' => TRUE,
				),
				'user_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'org_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'accesslevel' => array(
						'type' => 'INT',
						'constraint' => '11',
				),
				'terms_accepted' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'dateadded' => array(
					'type' => 'BIGINT',
					'constraint' => 12,
					'null' => FALSE,
				),		
				'dateapproved' => array(
					'type' => 'BIGINT',
					'constraint' => 12,
					'null' => FALSE,
				),	
				'approval_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'dateremoved' => array(
					'type' => 'BIGINT',
					'constraint' => 12,
					'null' => FALSE,
				),
				'notes' => array(
						'type' => 'TEXT'
				)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('user2org',TRUE);
		/*
		 * Create category table
		 */
		$fields = array(
				'ID' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'auto_increment' => TRUE,
				),
				'title' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						'null' => FALSE,
				),
				'slug' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						'null' => FALSE,
				),
				'description' => array(
						'type' => 'TEXT'
				),
				'dateadded' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'dateremoved' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'notes' => array(
						'type' => 'TEXT'
				)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('category',TRUE);
		/*
		 * Create cat2org table
		*/
		$fields = array(
				'ID' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'auto_increment' => TRUE,
				),
				'cat_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'parent_cat_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'org_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'allows' => array(
						'type' => 'TEXT'
				),
				'dateadded' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'dateremoved' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'notes' => array(
						'type' => 'TEXT'
				)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('cat2org',TRUE);
		/*
		 * Create post table
		 */
		$fields = array(
			'ID' => array(
				'type' => 'BIGINT',
				'constraint' => '11',
				'auto_increment' => TRUE,
			),
			'title' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE,
			),
			'slug' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE,
			),
			'author_id' => array(
				'type' => 'BIGINT',
				'constraint' => '11',
			),
			'cost' => array(
				'type' => 'VARCHAR',
				'constraint' => '255',
				'null' => FALSE,
			),
			'content' => array(
				'type' => 'TEXT'
			),
			'lastedit' => array(
				'type' => 'BIGINT',
				'constraint' => 12,
				'null' => FALSE,
			),
			'dateadded' => array(
				'type' => 'BIGINT',
				'constraint' => 12,
				'null' => FALSE,
			),		
			'datepublished' => array(
				'type' => 'BIGINT',
				'constraint' => 12,
				'null' => FALSE,
			),		
			'dateremoved' => array(
				'type' => 'BIGINT',
				'constraint' => 12,
				'null' => FALSE,
			),
			'notes' => array(
				'type' => 'TEXT'
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('post',TRUE);
		/*
		 * Create post2cat table
		 * Use the cat2org id to restrain the post to a given org. 
		 */
		$fields = array(
			'ID' => array(
				'type' => 'BIGINT',
				'constraint' => '11',
				'auto_increment' => TRUE,
			),
			'post_id' => array(
				'type' => 'BIGINT',
				'constraint' => '11',
				'null' => FALSE,
			),
			'cat_id' => array(
				'type' => 'BIGINT',
				'constraint' => '11',
				'null' => FALSE,
			),
			'orgcat_id' => array(
				'type' => 'BIGINT',
				'constraint' => '11',
				'null' => FALSE,
			),
			'notes' => array(
				'type' => 'TEXT'
			)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('post2cat',TRUE);
		/*
		 * Create attachment table
		*/
		$fields = array(
				'ID' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'auto_increment' => TRUE,
				),
				'attachment_url' => array(
						'type' => 'TEXT',
				),
				'attachment_type' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
				),
				'title' => array(
						'type' => 'VARCHAR',
						'constraint' => '255',
						'null' => TRUE,
				),
				'lastedit' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'dateadded' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'dateremoved' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('attachment',TRUE);
		
		/*
		 * Create attachment2post match table
		*/
		$fields = array(
				'ID' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'auto_increment' => TRUE,
				),
				'attachment_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'post_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'null' => FALSE,
				),
				'dateadded' => array(
					'type' => 'BIGINT',
					'constraint' => 12,
					'null' => FALSE,
				),	
				'dateremoved' => array(
					'type' => 'BIGINT',
					'constraint' => 12,
					'null' => FALSE,
				),
				'notes' => array(
						'type' => 'TEXT'
				)
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('attachment2post',TRUE);
		/*
		 * Create histroy table
		 */
		$fields = array(
				'ID' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
						'auto_increment' => TRUE,
				),
				'story_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
				),
				'user_id' => array(
						'type' => 'BIGINT',
						'constraint' => '11',
				),
				'data' => array(
						'type' => 'text',
				),
				'timestamp' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
				'restored' => array(
						'type' => 'BIGINT',
						'constraint' => 12,
						'null' => FALSE,
				),
		);
		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('ID',TRUE);
		$this->dbforge->create_table('history',TRUE);
		/*
		 * Add initial installation data
		 */
		// add administration org (pros)
		$db_data = array(
			'name' => 'Administrators',
			'accesslevel' => 1,
			'dateadded' => time()
		);
		$this->db->insert('user_group',$db_data);
		$admin_group_id = $this->db->insert_id();
		// add a god-level user
		$db_data = array(
			'email' => $_POST['user_email'],
			'password' => md5($_POST['user_pwd']),
			'firstname' => $_POST['user_fname'],
			'lastname' => $_POST['user_lname'],
			'accesslevel' => 1,
			'group_id' => $admin_group_id,
			'dateadded' => time(),
			'notes' => 'Initial user added with installation.'
		);
		$this->db->insert('user',$db_data);
		// add the client
		$db_data = array(
			'email' => 'mirja@aristogroup.com',
			'password' => md5('testpass'),
			'firstname' => 'Mirja',
			'lastname' => 'Zelistra',
			'accesslevel' => 1,
			'group_id' => $admin_group_id,
			'dateadded' => time(),
			'notes' => 'Secondary user added with installation.'
		);
		$this->db->insert('user',$db_data);
		/*
		 * Create array of levels
		 */
		$levels = array();
		$levels[1] = 'super-administrators';
		$levels[10] = 'administrators';
		$levels[20] = 'editors';
		$levels[50] = 'authors';
		$levels[100] = 'users';

		$db_data = array(
			'sysinfo_key' => 'access_levels',
			'sysinfo_value' => serialize($levels)
		);
		$this->db->insert('system_info',$db_data);
		/*
		 * Create array of attachment types
		*/
		$attachments = array();
		$attachments[10] = 'image';
		$attachments[20] = 'document';
		$attachments[30] = 'video';
		
		$db_data = array(
				'sysinfo_key' => 'attachment_types',
				'sysinfo_value' => serialize($levels)
		);
		$this->db->insert('system_info',$db_data);
		
		/*
		 * Finally set the versions and install data
		 */
		//set version
		$db_data = array(
			'sysinfo_key' => 'version',
			'sysinfo_value' => '0.1'
		);
		$this->db->insert('system_info',$db_data);
		$db_data = array(
			'sysinfo_key' => 'install_date',
			'sysinfo_value' => time()
		);
		$this->db->insert('system_info',$db_data);
		$db_data = array(
			'sysinfo_key' => 'last_update',
			'sysinfo_value' => time()
		);
		$this->db->insert('system_info',$db_data);


		//should we do the initial data import?
		if(!empty($_POST['installdata'])){
			$this->installdata(true);
		}

		//now do any upgrades
		$this->upgrade();

		//redirect to home page
		$this->load->helper('url');
		redirect('/login');

	}

	/*
	 * Install data grabs sql file and installs it.
	 */
	function installdata($initial_install = false, $location = 'application/assets/uploads/sql/initial_data.sql'){
		if($this->session->userdata['ID'] == 1 || $initial_install == true){
			//read the file
			$file = $this->load->file($location, true);

			//explode it in an array
			if(preg_match('/local/i',$_SERVER['SERVER_NAME'])){
				$split = ";\n";
			} else {
				$split = ";\r";
			}
			$file_array = explode($split, $file);

			//execute the exploded text content
			foreach($file_array as $query){
				$query = trim($query);
				if(!empty($query)){
			    	$this->db->query($query);
				}
			}
		}
	}


	/*
	 * Uninstall for quick rebuilds
	 */
	function uninstall(){
		$tables = $this->db->list_tables();

		foreach ($tables as $table)
		{
			$this->dbforge->drop_table($table);
		}
	}

	/*
	 * Upgrade script, add new tables here.
	 */
	function upgrade()
	{
		//get system version
		if($this->db->table_exists('system_info')){
			$this->db->where('sysinfo_key','version');
			$query = $this->db->get('system_info',1);
			if ($query->num_rows() > 0){
				foreach ($query->result() as $row){
					$version = $row->sysinfo_value;
				}
			} else {
				exit('Error: version cannot be read!');
			}
		} else {
			$version = '0.1';
		}
		//if we are already at the current version, escape
		//should never happen
		if($version == $this->db_version){
			print 'Database is already at the most recent revision.';
		}

		//get the db forge
		$this->load->dbforge();
		//run updates
		switch($version){
			case '0.1':
				//add default content for organizations
				$db_data = array(
					'name' => 'Summit Country Day Knights',
					'slug' => 'summit-country-day-knights',
					'description' => '',
					'dateadded' => time()
				);
				$this->db->insert('organization',$db_data);
				//set version
				$this->set_version('0.2');
			case '0.2':
				/*
				 * Create org_meta table
				*/
				$fields = array(
						'ID' => array(
								'type' => 'BIGINT',
								'constraint' => '11',
								'auto_increment' => TRUE,
						),
						'user_id' => array(
								'type' => 'BIGINT',
								'constraint' => '11',
								'null' => FALSE,
						),
						'org_id' => array(
								'type' => 'BIGINT',
								'constraint' => '11',
								'null' => FALSE,
						),
						'meta_key' => array(
								'type' => 'VARCHAR',
								'constraint' => '255',
								'null' => FALSE,
						),
						'meta_value' => array(
								'type' => 'TEXT'
						),
						'dateadded' => array(
								'type' => 'BIGINT',
								'constraint' => 12,
								'null' => FALSE,
						),
						'dateremoved' => array(
								'type' => 'BIGINT',
								'constraint' => 12,
								'null' => FALSE,
						),
						'notes' => array(
								'type' => 'TEXT'
						)
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('ID',TRUE);
				$this->dbforge->create_table('user_meta',TRUE);
				//set version
				$this->set_version('0.2');
			case '0.2':
				/*
				 * Create article table
				*/
				$fields = array(
						'ID' => array(
								'type' => 'BIGINT',
								'constraint' => '11',
								'auto_increment' => TRUE,
						),
						'title' => array(
								'type' => 'VARCHAR',
								'constraint' => '255',
								'null' => FALSE,
						),
						'slug' => array(
								'type' => 'VARCHAR',
								'constraint' => '255',
								'null' => FALSE,
						),
						'excerpt' => array(
								'type' => 'TEXT'
						),
						'content' => array(
								'type' => 'TEXT'
						),
						'dateadded' => array(
								'type' => 'BIGINT',
								'constraint' => 12,
								'null' => FALSE,
						),
						'dateremoved' => array(
								'type' => 'BIGINT',
								'constraint' => 12,
								'null' => FALSE,
						),
						'notes' => array(
								'type' => 'TEXT'
						)
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('ID',TRUE);
				$this->dbforge->create_table('article',TRUE);
				/*
				 * Create art2org table
				*/
				$fields = array(
						'ID' => array(
								'type' => 'BIGINT',
								'constraint' => '11',
								'auto_increment' => TRUE,
						),
						'art_id' => array(
								'type' => 'BIGINT',
								'constraint' => '11',
								'null' => FALSE,
						),
						'parent_art_id' => array(
								'type' => 'BIGINT',
								'constraint' => '11',
								'null' => FALSE,
						),
						'org_id' => array(
								'type' => 'BIGINT',
								'constraint' => '11',
								'null' => FALSE,
						),
						'allows' => array(
								'type' => 'TEXT'
						),
						'dateadded' => array(
								'type' => 'BIGINT',
								'constraint' => 12,
								'null' => FALSE,
						),
						'dateremoved' => array(
								'type' => 'BIGINT',
								'constraint' => 12,
								'null' => FALSE,
						),
						'notes' => array(
								'type' => 'TEXT'
						)
				);
				$this->dbforge->add_field($fields);
				$this->dbforge->add_key('ID',TRUE);
				$this->dbforge->create_table('art2org',TRUE);
				//set version
				$this->set_version('0.3');
            case '0.3':
                /*
                 * Create post_meta table
                */
                $fields = array(
                        'ID' => array(
                                'type' => 'BIGINT',
                                'constraint' => '11',
                                'auto_increment' => TRUE,
                        ),
                        'post_id' => array(
                                'type' => 'BIGINT',
                                'constraint' => '11',
                                'null' => FALSE,
                        ),
                        'meta_key' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                                'null' => FALSE,
                        ),
                        'meta_value' => array(
                                'type' => 'TEXT'
                        ),
                        'dateadded' => array(
                                'type' => 'BIGINT',
                                'constraint' => 12,
                                'null' => FALSE,
                        ),
                        'dateremoved' => array(
                                'type' => 'BIGINT',
                                'constraint' => 12,
                                'null' => FALSE,
                        ),
                        'notes' => array(
                                'type' => 'TEXT'
                        )
                );
                $this->dbforge->add_field($fields);
                $this->dbforge->add_key('ID',TRUE);
                $this->dbforge->create_table('post_meta',TRUE);
                /**
                 * Add column type to post table
                 */
                 $fields = array(
                        'type' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                                'null' => FALSE,
                        ),
                );
                $this->dbforge->add_column('post', $fields, 'slug');
                /**
                 * Add types array to sys_admin for themed output
                 */
                $post_types = array();
                $post_types['product'] = 'Single Item';
                $post_types['service'] = 'Service provided by adult';
                $post_types['student-service'] = 'Service provided by a student';
                //$post_types['request'] = 'Seeking Product/Service';
                
                $db_data = array(
                    'sysinfo_key' => 'post_types',
                    'sysinfo_value' => serialize($post_types)
                );
                $this->db->insert('system_info',$db_data);
                //set version
                $this->set_version('0.4');
            case '0.4':
                /**
                 * Add column pageorder to article
                 */
                 $fields = array(
                        'pageorder' => array(
                                'type' => 'BIGINT',
                                'constraint' => 12,
                                'null' => FALSE,
                        ),
                );
                $this->dbforge->add_column('article', $fields, 'content');
                //set version
                $this->set_version('0.5');
            case '0.5':
                /**
                 * Create table for invoice tracking
                 */
                 /*
                 * Create invoice table
                */
                $fields = array(
                        'ID' => array(
                                'type' => 'BIGINT',
                                'constraint' => '11',
                                'auto_increment' => TRUE,
                        ),
                        'org_id' => array(
                                'type' => 'BIGINT',
                                'constraint' => '11',
                                'null' => FALSE,
                        ),
                        'author_id' => array(
                                'type' => 'BIGINT',
                                'constraint' => '11',
                                'null' => FALSE,
                        ),
                        'post_id' => array(
                                'type' => 'BIGINT',
                                'constraint' => '11',
                                'null' => FALSE,
                        ),
                        'fee' => array(
                                'type' => 'VARCHAR',
                                'constraint' => '255',
                                'null' => FALSE,
                        ),
                        'dateadded' => array(
                                'type' => 'BIGINT',
                                'constraint' => 12,
                                'null' => FALSE,
                        ),
                        'dateremoved' => array(
                                'type' => 'BIGINT',
                                'constraint' => 12,
                                'null' => FALSE,
                        ),
                        'notes' => array(
                                'type' => 'TEXT'
                        )
                );
                $this->dbforge->add_field($fields);
                $this->dbforge->add_key('ID',TRUE);
                $this->dbforge->create_table('invoice',TRUE);
                //set version
                $this->set_version('0.6');
			default:
				//redirect to home page
				$this->load->helper('url');
				redirect('/login');
				die();
		}
	}

	private function set_version($version){
		$this->db->where('sysinfo_key','version');
		$db_data = array(
			'sysinfo_key' => 'version',
			'sysinfo_value' => $version
		);
		$this->db->update('system_info',$db_data);
		$this->db->where('sysinfo_key','last_update');
		$db_data = array(
			'sysinfo_key' => 'last_update',
			'sysinfo_value' => time()
		);
		$this->db->update('system_info',$db_data);
	}
	
	public function get_update_version(){
		return $this->db_version;
	}

	public function backup_db(){	
		// Load the DB utility class
		$this->load->dbutil();
		
		// Backup your entire database and assign it to a variable
		$backup =& $this->dbutil->backup();
				
		// Load the download helper and send the file to your desktop
		$this->load->helper('download');
		$filename = SITENAME.'_'.date('Ymdhis').'.gz';
		force_download($filename, $backup); 
	}
}

/* End of file install.php */
/* Location: ./application/models/install.php */