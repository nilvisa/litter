
foreach($post as $post)
{
    postComment($post['post_id']);
    replyComment($post['reply']);

        /*MENTIONED IN A COMMENT*/
        if($post['reply'] > 0)
        {   
            
            $comments = getComment($post['reply']);

            if(!empty($comments))
            {
                print '<div class="postit"><ul>';

                    foreach($comments as $comments)
                    {
                        if($comments['post'] == $post['post'])
                        {
                            /*THE @_COMMENT*/
                            print '<li class="postit atcomment">';
                            print '<a name="'.$comments['post_id'].'"></a>';

                                /*WHO AND WHEN MENTIONED*/
                                print '<p><i>'.printTime($comments['time_stamp']).', '.atLink($comments['username']).' mentioned you in a comment:</i></p>';

                            
                                /*DELETE_BUTTON*/
                                if($sess['user_id'] == $comments['user_id'])
                                {
                                    print '<div class="del_post">';
                                        print '<form method="POST">
                                                <input type="hidden" name="post_id" value="'.$comments['post_id'].'">
                                                <button type="submit" name="del_comment"><img src="img/trashicon.png"></button>
                                            </form>';
                                    print '</div>';
                                }
                                /*END DELETE_BUTTON*/

                                print '<div class="profile_img">'.getProfilePic($post['user_id'], '50px').'</div>';
                                print '<h3>'.atLink($comments['username']).':</h3>';
                                print ' "'.atLink($post['post']).'"</p><br><br>';

                                /*REPLY_FORM*/
                                print '<div class="reply">
                                        <form method="POST" action="#'.$comments['post_id'].'">
                                        <input type="text" name="comment" value="'.$post['username'].'">
                                        <input type="submit" name="'.$post['reply'].'" value="Reply" class="button">
                                        </form>
                                        </div>';
                                /*END REPLY_FORM*/

                            print '</li>';
                            /*END THE @_COMMENT*/
                        }
                        else
                        {
                            print '<li>';
                                /*DELETE_BUTTON*/
                                if($sess['user_id'] == $comments['user_id'])
                                {
                                    print '<div class="del_post">';
                                        print '<form method="POST">
                                                <input type="hidden" name="post_id" value="'.$comments['post_id'].'">
                                                <button type="submit" name="del_comment"><img src="img/trashicon.png"></button>
                                            </form>';
                                    print '</div>';
                                }
                                /*END DELETE_BUTTON*/

                                /*COMMENT*/
                                print '<h3>'.atLink($comments['username']).':</h3>';
                                print '<p>'.atLink($comments['post']).'</p>';

                            print '</li>';
                        }
                    }

                print '</ul>';
            }
            
            

            $post = getCommentsPost($post['reply']);

            if($post['recycle'] > 0)
             {
                print '<div class="post paper">';
             }
            else
             {
                print '<div class="post">';
             }

             print '<p>on:</p>';

            /*DELETE_BUTTON*/
            if($sess['user_id'] == $post['user_id'])
            {
                print '<div class="del_post">';
                    print '<form method="POST">
                            <input type="hidden" name="post_id" value="'.$post['post_id'].'">
                            <button type="submit" name="del_post"><img src="img/trashicon.png"></button>
                        </form>';
                print '</div>';
            }
            /*END DELETE_BUTTON*/

            /*RECYCLED*/
            $recycle = $post['recycle'];
            $repost_id = $post['post_id'];
            $reusername = $post['username'];
            if($post['recycle'] > 0)
            {
                print '<div class="profile_img">'.getProfilePic($post['user_id'], '50px').'</div>';
                print isOnline($post['active']);
                print '<h4>'.$post['f_name'].' '.$post['l_name'].'</h4>';
                print '<h3> '.atLink($post['username']).'</h3><h4> recycled:</h4>';

                $post = getRecycledPost($recycle);
                print '<div class="rePost">';
            }

            /*RECYCLE_BUTTON*/
            if($post['user_id'] !== $sess['user_id'])
            {
                print '<div class="recycle">';
                    print '<form method="POST">
                            <input type="hidden" name="post_id" value="'.$post['post_id'].'">
                            <button type="submit" name="recycle"><img src="img/recycle.png"> Recycle</button>
                        </form>';
                print '</div>';
            }
            /*END RECYCLE_BUTTON*/

            print '<a name="'.$post['post_id'].'"></a>';
            /*POST*/
            print '<div class="profile_img">'.getProfilePic($post['user_id'], '50px').'</div>';
            print isOnline($post['active']);
            print '<h4>'.$post['f_name'].' '.$post['l_name'].' </h4>';
            print '<h3>'.atLink($post['username']).': </h3>';
            print '<p class="post_post">'.atLink($post['post']).'</p>';

            if($post['post_pic'])
            {
                print '<img src="userIMG/'.$post['user_id'].'/'.$post['post_pic'].'" class="post_img">';
            }
            print '<div class="time_stamp"><p>'.printTime($post['time_stamp']).'</p></div>';



            if($post == getRecycledPost($recycle))
            {
                print '</div></div>';
                $post['post_id'] = $repost_id;
                $post['username'] = $reusername;
            }
            /*END RECYCLED*/

            print '<br><br>';

        }
