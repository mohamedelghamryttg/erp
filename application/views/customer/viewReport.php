<html>
<body>
<table class="table table-striped table-hover table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                               
                            </tr>
                        </thead> 
                        <tbody>
                        <?php
                            foreach($row as $row)
                                {
                         $result = $this->db->query("SELECT * FROM customer WHERE id = '$row->customer'")->row();
                            ?>
                                    <tr class="">
                                        <td><?=$row->id?></td>
                                        <td><?php echo $result->name ;?></td>
                                    </tr>
                        <?php  } ?>      
                        </tbody>
                    </table>
</body>
</html>