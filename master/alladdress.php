<?php
   require_once("../database/connection.php");
   require_once("../database/curl_call.php");
   
   if(!isset($_SESSION['id'])){
       header('location:login.php');
   }
      @$user_id=$_POST['user_id'];
      $url = $BaseURL +"/api/fetchUserAddress.php/";  
      $content = json_encode(array('fetch'=>$user_id),JSON_FORCE_OBJECT);                  
      $response=curlcall($url,$content);

   ?>
<div>
    <section class="section">
        <div class="section-header">
            <h1>Suppliers</h1>
        </div>

        <div class="section-body">
            <div id="productinfo" class="section-body">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <div class="form-group fa-pull-right">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModalCenter">
                                    Add
                                </button>
                            </div>


                            <table class="table table-bordered" id="tbl_posts">
                                <thead style="background-color: #956f00">
                                    <tr>
                                        <th>Name</th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Mobile
                                        </th>
                                        <th>
                                            Timestamp
                                        </th>
                                        <th>
                                            Feedback
                                        </th>
                                        <th>
                                            Orders
                                        </th>
                                        <th>
                                            Address
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tbl_posts_body">
                                    <?php foreach ($response as $row) { ?>
                                        <tr>
                                            <td id="mobileno"><b><?= @$row['name']; ?></b></td>
                                            <td><?= @$row['email']; ?></td>
                                            <td><?= @$row['phone']; ?></td>
                                            <td>2020-09-12:09:09:99</td>
                                            <td>Good items & Delivery</td>
                                            <td>
                                                <form method="POST" action="allorder.php">
                                                    <input type="hidden" name="user_id" value="<?php echo @$row['id']; ?>" />
                                                    <button class="btn btn-outline-litil btn-sm" type="submit">All Orders</button>
                                                </form>
                                            </td>

                                            <td>
                                                <form method="POST" action="alladdress.php">
                                                    <input type="hidden" name="user_id" value="<?php echo @$row['id']; ?>" />
                                                    <button class="btn btn-outline-litil btn-sm" type="submit">All Address</button>
                                                </form>
                                            </td>

                                        </tr>
                                    <?php   } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    
</div>