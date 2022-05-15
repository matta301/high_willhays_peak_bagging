<?php
// echo plugin_dir_url( __DIR__ );
function display_historic_county_profile( $user_image, $user_id, $membership_date, $initials ) { 

    $delete_error = isset( $_GET['delete'] ) ? true : false;
?>
<div>
    <h1>Your profile</h1>
</div>
<form action="<?php echo esc_url( admin_url('admin-post.php') ); ?>" method="post" enctype="multipart/form-data">   
    <div class="row profile-page"> 
        <div class="col">    
            <input type="hidden" name="destroySession" value="1">
            <input name='action' type="hidden" value='historic_tops_update_profile'>
            <?php wp_nonce_field('_wpnonce'); ?>

            <div class="row">
                <div class="col">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">User ID:</label>
                        <input type="text" class="form-control-plaintext" id="user_id" value="<?php echo esc_html( $user_id ); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Member since:</label>
                        <input type="text" class="form-control-plaintext" id="user_login" value="<?php echo esc_html( $membership_date ); ?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Username:</label>
                        <input 
                            type="text" 
                            class="form-control-plaintext" 
                            id="user_login" 
                            value="<?php echo esc_html( get_the_author_meta( 'user_login', $user_id ) ); ?>"
                            readonly
                        >
                    </div>
                </div>
                <div class="col">
                    <div class="text-end">
                        <div class="profile-image-wrapper border border-2" <?php if( $user_image != null) { ?>style="background-image: url('<?php echo $user_image ?>');"<?php } ?>>
                            <?php if( $user_image == null ) { ?>
                                <svg class="bd-placeholder-img img-thumbnail" width="200" height="200" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="A generic square placeholder image with a white border around it, making it resemble a photograph taken with an old instant camera: 200x200" preserveAspectRatio="xMidYMid slice" focusable="false">
                                    <title>A generic square placeholder image with a white border around it, making it resemble a photograph taken with an old instant camera</title><rect width="100%" height="100%" fill="#868e96"></rect>
                                </svg>
                                <span><?php echo $initials; ?></span>
                            <?php } ?>
                        </div>
                        <div class="mb-3">
                            <input class="form-control form-control-sm" id="profile_iamge" type="file" name="profile_iamge">
                        </div>
                        
                        <?php if (isset( $_GET['file_size'] )) { ?><p class="form-error text-danger">File size is too big. (4 MB Max)</p><?php } ?>
                        <?php if (isset( $_GET['file_type'] )) { ?><p class="form-error text-danger">Wrong file format. (.png, .jpg)</p><?php } ?>

                        <?php if( $user_image != null ) { ?>
                        <button type="submit" name="submit_profile" class="btn btn-outline-danger" value="delete_image">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                            </svg>                            
                        </button>
                        <?php } ?>
                        <?php if( $user_image == null ) { ?>
                            <button type="submit" name="submit_profile" class="btn btn-primary" value="upload_image">
                                Upload Image
                            </button>
                        <?php }else { ?>
                            <button type="submit" name="submit_profile" class="btn btn-primary" value="update_image">
                                Update Image
                            </button>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <label for="first_name" class="form-label">First Name:</label>
                <input 
                    type="text" 
                    class="form-control form-control-lg" 
                    id="first_name" 
                    name="first_name" 
                    value="<?php echo esc_html( get_the_author_meta( 'user_firstname', $user_id ) );  ?>"
                >
            </div>
            <div class="mb-3">
                <label for="last_name" class="form-label">Last Name:</label>
                <input 
                    type="text" 
                    class="form-control form-control-lg" 
                    id="last_name" 
                    name="last_name"
                    value="<?php echo esc_html( get_the_author_meta( 'user_lastname', $user_id ) ); ?>"
                >
            </div>
        </div>

        <div class="col">
            <div class="mb-3">
                <label for="county" class="form-label">County:</label>
                <input 
                    type="text" 
                    class="form-control form-control-lg" 
                    id="county" 
                    name="county"
                    value="<?php echo get_the_author_meta( 'peak_bagging_county', $user_id ); ?>"
                >
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Bio:</label>
                <textarea class="form-control" id="description" name="description" rows="8"><?php echo esc_textarea( get_the_author_meta( 'user_description', $user_id ) ); ?></textarea>
            </div>
            <button type="submit" class="update-details-button btn btn-primary" name="submit_profile" value="update_profile">Update your details</button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="accordion" id="accordionExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="headingOne">
                        <button class="accordion-button text-danger" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Delete Account
                        </button>
                    </h2>
                    <div id="collapseOne" class="accordion-collapse collapse <?php if ( $delete_error ) { echo 'show'; } ?>" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                        <div class="accordion-body text-danger">
                            You are about to delete your account, are you sure? This is permament and will delete all data including profile data, progress and any images.<br/>
                            To continue, type <strong>DELETE PEAKBAGGING</strong> and click the submit button.
                            <div class="my-3">
                                <input type="text" class="js-delete-peakbagging-account" name="delete_peakbagging_account" />
                                <?php if ( $delete_error ) { ?><div> Something went wrong, please try again. Phrase should be in all caps.</div><?php } ?>
                            </div>
                            <div class="my-3">
                                <button type="submit" name="submit_profile" class="btn btn-danger" value="delete_account">Delete Account</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<?php } ?>