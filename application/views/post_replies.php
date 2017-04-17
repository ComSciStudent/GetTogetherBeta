<?php
$user = $post->user;
$logged_user = $_SESSION['logged_user'];
if ($post->parent_id !== '0'):
    ?>
    <div class = "media" style = "border-left: 1px solid gray;">
        <?php if (!$post->is_deleted): ?>
            <div class = "media-left text-center no-margin no-padding">
                <img src="<?php echo $user->profile_url ? base_url($user->profile_url) : base_url('images/default.jpg'); ?>" class="img-circle reply-pic pull-left">
            </div>
        <?php else: ?>
            <div class = "media-left"></div>
        <?php endif; ?>
        <div class="media-body">
            <?php if (!$post->is_deleted): ?>
                <?php if ($user->user_id === $logged_user->user_id): ?>
                    <!-- Delete Button -->
                    <button value = "<?php echo $post->post_id ?>" class = "delete-btn pull-right btn btn-sm btn-danger"><i class = "fa fa-trash"></i></button>
                <?php endif; ?>
                <button class = "reply-btn pull-right btn btn-sm btn-gray" style = "margin-right: 5px;" value = "<?php echo $post->post_id; ?>">
                    <i class = "fa fa-reply"></i>
                </button>
                <?php if ($post->user->user_id === $logged_user->user_id): ?>
                    <!-- Edit Button -->
                    <button class = "edit-btn pull-right btn btn-sm btn-gray" style = "margin-right: 5px;"  value = "<?php echo $post->post_id; ?>"><i class = "fa fa-pencil"></i></button>
                <?php
                endif;
                if (!empty($post->attachments)):
                    ?>
                    <button value = "<?php echo $post->post_id; ?>" class = "attachment-btn btn btn-primary btn-sm text-left pull-right" style = "margin-right: 5px;">
                        <strong><i class = "fa fa-paperclip" style = "font-size: 15px;"></i> <?php echo count($post->attachments); ?></strong>
                    </button>
                <?php endif; ?>

                <div class = "pull-left text-center">
                    <button class = "upvote-btn btn btn-link btn-xs" style = "margin-left: 3px;" value = "<?php echo $post->post_id; ?>">
                        <span class = "<?php echo $post->vote_type === '1' ? 'upvote-text' : '' ?> fa fa-chevron-up vote-text"></span>
                    </button>
                    <br>
                    <span class = "vote-count text-muted" style = "margin-left: 3px;"><?php echo $post->vote_count ? $post->vote_count : '0'; ?></span>
                    <br>
                    <button class = "downvote-btn btn btn-link btn-xs" value = "<?php echo $post->post_id; ?>">
                        <span class = "<?php echo $post->vote_type === '-1' ? 'downvote-text' : '' ?> fa fa-chevron-down vote-text"></span>
                    </button>
                </div>
        <?php if ($post->post_title): ?>
                    <h4 class = "no-padding no-margin text-muted"><strong><?php echo $post->post_title; ?></strong></h4>
                    <small>
                        <i>by <a class = "btn btn-link btn-xs no-padding no-margin" href = "<?php echo base_url("user/profile/" . $post->user->user_id); ?>"><?php echo $post->user->first_name . " " . $post->user->last_name ?></a></i>
                        <span class = "text-muted"><i style = "font-size: 11px;"><?php echo date("M-d-y", strtotime($post->date_posted)); ?></i></span>
                    </small>
        <?php else: ?>
                    <a class = "btn btn-link no-padding btn-lg" href = "<?php echo base_url('user/profile/' . $user->user_id); ?>"><strong><?php echo $user->first_name . " " . $user->last_name; ?></strong></a>
                    <br>
                    <span class = "text-muted"><i style = "font-size: 11px;"><?php echo date("M-d-y", strtotime($post->date_posted)); ?></i></span>
        <?php endif; ?>
                <p class = "post-content" style = "margin-top: 15px;"><?php echo $post->post_content; ?></p>

    <?php else: ?>
                <div class="media-heading">
                    <h4 class = "no-padding no-margin text-danger">Deleted Post</h4>
                </div>
                <p class = "post-content text-muted" style = "margin-top: 15px"><i>This post has been deleted.</i></p>
            <?php endif; ?>
            <?php
            foreach ($post->replies as $child):
                $data['post'] = $child;
                $this->load->view('post_replies', $data);
            endforeach;
            ?>
        </div>
    </div>
    <?php
else:
    foreach ($post->replies as $child):
        $data['post'] = $child;
        $this->load->view('post_replies', $data);
    endforeach;
endif;