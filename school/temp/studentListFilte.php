<label class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3" for="filter">Filter by Class:</label>
                        <select id="filter" class="p-1 text-primary-emphasis border border-primary-subtle rounded-3" style="background-color: #78cc8e;">
                            <option value="all">All</option>
                            <?php   
                            foreach ($users as $user) {
                                if($user["role"] == "student"){
                                    $studentClassId = " ";
                                    foreach ($studentClasses as $studentClass) {
                                        if($studentClass["student_id"] == $user["id"]){
                                            $studentClassId = $studentClass["class_id"];
                                            break;
                                        }
                                    }
                                    
                                    $studentClassName = " ";
                                    foreach ($classes as $class) {
                                        if($studentClassId == $class["id"]){
                                            $studentClassName =  $class["class_name"];
                                            break;
                                        }
                                    }

                                    if(!empty($studentClassId) && $studentClassId != " "){
                                    ?>

                                        <option value="<?php echo $studentClassId; ?>"><?php echo $studentClassId; ?> - <?php echo $studentClassName;?></option>
                                    <?php 
                                    }}}
                            ?>
                        </select>



                        <label class="p-1 text-primary-emphasis bg-primary-subtle border border-primary-subtle rounded-3" for="filter">Filter by Exam Score:</label>
                                <select id="filter" class="p-1 text-primary-emphasis border border-primary-subtle rounded-3" style=" background-color : #78cc8e;">
                                    <option value="all">All</option>
                                    <option value="admin">0-24</option>
                                    <option value="teacher">25-49</option>
                                    <option value="student">50-69</option>
                                    <option value="student">70-100</option>
                                </select>
                    <table class="table">