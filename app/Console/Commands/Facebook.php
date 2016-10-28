<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Intervention\Image\ImageManagerStatic as Image;

class Facebook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cron:facebook';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get the facebook posts.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $fb = new \Facebook\Facebook([
            'app_id' => env('FACEBOOK_APP_ID'),
            'app_secret' => env('FACEBOOK_APP_SECRET'),
            'default_graph_version' => env('FACEBOOK_GRAPH_VERSION')
        ]);

        $at = env('FACEBOOK_APP_ID') . '|' . env('FACEBOOK_APP_SECRET');

        //get posts
        $fields = [
            'id',
            'created_time',
            'story',
            'message',
            'icon',
            'attachments',
            'type',
            'comments',
            'likes',
            'object_id'
        ];
        $res = $fb->get('gunsnbits/posts?locale=de&fields=' . implode(',', $fields), $at);
        if ($res instanceof \Facebook\FacebookResponse && $res->getThrownException() == null) {

            //dd($res->getDecodedBody());

            foreach ($res->getDecodedBody()['data'] as $data) {

                //dd($this->linkMessage($data['message']));

                if ($fbpost = \App\Fbpost::where('fb_id', '=', $data['id'])->first()) {
                    //update
                    $fbpost->type = isset($data['type']) ? $data['type'] : '';
                    $fbpost->story = (isset($data['story'])) ? $data['story'] : '';
                    $fbpost->message = (isset($data['message'])) ? $this->linkMessage($data['message']) : '';
                    $fbpost->icon = (isset($data['icon'])) ? basename($data['icon']) : '';
                    $fbpost->likes = (isset($data['likes']) && isset($data['likes']['data'])) ? count($data['likes']['data']) : 0;
                    $time = new Carbon($data['created_time']);
                    $fbpost->created_time = $time->format('Y-m-d H:i:s');

                    $fbpost->save();
                }
                else {
                    //insert
                    $fbpost = new \App\Fbpost();
                    //fill
                    $fbpost->fb_id = $data['id'];
                    $fbpost->type = isset($data['type']) ? $data['type'] : '';
                    $fbpost->story = (isset($data['story'])) ? $data['story'] : '';
                    $fbpost->message = (isset($data['message'])) ? $this->linkMessage($data['message']) : '';
                    $fbpost->icon = (isset($data['icon'])) ? basename($data['icon']) : '';
                    $fbpost->likes = (isset($data['likes']) && isset($data['likes']['data'])) ? count($data['likes']['data']) : 0;
                    $time = new Carbon($data['created_time']);
                    $fbpost->created_time = $time->format('Y-m-d H:i:s');

                    $fbpost->save();
                }

                //insert attached images
                if (isset($data['attachments']) && isset($data['attachments']['data'])) {
                    foreach ($data['attachments']['data'] as $attachment) {

                        //images in subattachments?
                        if (isset($attachment['subattachments']) && isset($attachment['subattachments']['data'])) {
                            foreach ($attachment['subattachments']['data'] as $attachmentdata) {

                                if (isset($attachmentdata['media']) && isset($attachmentdata['media']['image'])) {

                                    if ($fbpost->images()->where('src', '=', $attachmentdata['media']['image']['src'])->count() == 0) {

                                        $fbpostimage = new \App\Fbpostimage();
                                        $fbpostimage->type = $attachmentdata['type'];
                                        $fbpostimage->url = (isset($attachmentdata['url'])) ? $attachmentdata['url'] : '';
                                        $fbpostimage->title = (isset($attachmentdata['title'])) ? $attachmentdata['title'] : '';
                                        $fbpostimage->description = (isset($attachmentdata['description'])) ? $this->linkMessage($attachmentdata['description']) : '';
                                        $fbpostimage->src = $attachmentdata['media']['image']['src'];
                                        $fbpostimage->height = $attachmentdata['media']['image']['height'];
                                        $fbpostimage->width = $attachmentdata['media']['image']['width'];

                                        $ext = 'jpg';
                                        if (preg_match('/(.*)\.jpg(.*)/', $attachmentdata['media']['image']['src'])) {
                                            $ext = 'jpg';
                                        } elseif (preg_match('/(.*)\.png(.*)/', $attachmentdata['media']['image']['src'])) {
                                            $ext = 'png';
                                        } elseif (preg_match('/(.*)\.gif(.*)/', $attachmentdata['media']['image']['src'])) {
                                            $ext = 'gif';
                                        }
                                        else {
                                            //no type found... url is a php file?
                                            if (preg_match('/(.*)\.php\?(.*)/', $attachmentdata['media']['image']['src'])) {

                                            }
                                        }

                                        //generate file name
                                        $sha1 = sha1($attachmentdata['media']['image']['src']);
                                        $fbpostimage->basename = $sha1 . '.' . $ext;

                                        //get image
                                        if (!file_exists(public_path('images/facebook/' . $fbpostimage->basename))) {

                                            $url = $attachmentdata['media']['image']['src'];

                                            $ch = curl_init();
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                            curl_setopt($ch, CURLOPT_HEADER, false);
                                            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                                            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                            curl_setopt($ch, CURLOPT_URL, $url);
                                            curl_setopt($ch, CURLOPT_REFERER, $url);
                                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                            $result = curl_exec($ch);
                                            curl_close($ch);

                                            file_put_contents(public_path('images/facebook/' . $fbpostimage->basename), $result);
                                            //Image::make($attachmentdata['media']['image']['src'])->save(public_path('images/facebook/' . $fbpostimage->basename));
                                        }

                                        //save
                                        $fbpost->images()->save($fbpostimage);

                                    }

                                }

                            }
                        }
                        //images in attachments directly
                        else {
                            if (isset($attachment['media']) && isset($attachment['media']['image'])) {

                                if ($fbpost->images()->where('src', '=', $attachment['media']['image']['src'])->count() == 0) {

                                    $fbpostimage = new \App\Fbpostimage();
                                    $fbpostimage->type = $attachment['type'];
                                    $fbpostimage->url = $attachment['url'];
                                    $fbpostimage->title = (isset($attachment['title'])) ? $attachment['title'] : '';
                                    $fbpostimage->description = (isset($attachment['description'])) ? $this->linkMessage($attachment['description']) : '';
                                    $fbpostimage->src = $attachment['media']['image']['src'];
                                    $fbpostimage->height = $attachment['media']['image']['height'];
                                    $fbpostimage->width = $attachment['media']['image']['width'];

                                    $ext = 'jpg';
                                    if (preg_match('/(.*)\.jpg(.*)/', $attachment['media']['image']['src'])) {
                                        $ext = 'jpg';
                                    } elseif (preg_match('/(.*)\.png(.*)/', $attachment['media']['image']['src'])) {
                                        $ext = 'png';
                                    } elseif (preg_match('/(.*)\.gif(.*)/', $attachment['media']['image']['src'])) {
                                        $ext = 'gif';
                                    }

                                    //generate file name
                                    $sha1 = sha1($attachment['media']['image']['src']);
                                    $fbpostimage->basename = $sha1 . '.' . $ext;

                                    //get image
                                    if (!file_exists(public_path('images/facebook/' . $fbpostimage->basename))) {

                                        $url = $attachmentdata['media']['image']['src'];

                                        $ch = curl_init();
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                                        curl_setopt($ch, CURLOPT_HEADER, false);
                                        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
                                        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
                                        curl_setopt($ch, CURLOPT_URL, $url);
                                        curl_setopt($ch, CURLOPT_REFERER, $url);
                                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                        $result = curl_exec($ch);
                                        curl_close($ch);

                                        file_put_contents(public_path('images/facebook/' . $fbpostimage->basename), $result);
                                        //Image::make($attachment['media']['image']['src'])->save(public_path('images/facebook/' . $fbpostimage->basename));
                                    }

                                    //save
                                    $fbpost->images()->save($fbpostimage);

                                }

                            }
                        }

                    }

                }

                //insert comments
                if (isset($data['comments']) && isset($data['comments']['data'])) {
                    foreach ($data['comments']['data'] as $comment) {

                        if ($fbcomment = \App\Fbcomment::where('fb_id', '=', $comment['id'])->first()) {
                            //update
                            $fbcomment->message = $this->linkMessage($comment['message']);
                            $fbcomment->from_name = $comment['from']['name'];
                            $fbcomment->from_id = $comment['from']['id'];
                            $time = new Carbon($comment['created_time']);
                            $fbcomment->created_time = $time->format('Y-m-d H:i:s');

                            $fbcomment->save();
                        }
                        else {
                            //insert
                            $fbcomment = new \App\Fbcomment();
                            $fbcomment->fb_id = $comment['id'];
                            $fbcomment->message = $this->linkMessage($comment['message']);
                            $fbcomment->from_name = $comment['from']['name'];
                            $fbcomment->from_id = $comment['from']['id'];
                            $time = new Carbon($comment['created_time']);
                            $fbcomment->created_time = $time->format('Y-m-d H:i:s');

                            $fbpost->comments()->save($fbcomment);
                        }

                    }
                }

            }
        }

        $this->info('Facebook posts successfully read.');
    }

    /**
     * Make urls to links in text.
     *
     * @param $text
     * @return mixed
     */
    protected function linkMessage($text) {
        //urls
        $reg_exUrl = "/(http|https|ftp|ftps)\:\/\/[a-zA-Z0-9\-\.]+\.[a-zA-Z]{2,3}(\/\S*)?/";
        preg_match_all($reg_exUrl, $text, $matches);
        $usedPatterns = array();
        foreach($matches[0] as $pattern){
            if(!array_key_exists($pattern, $usedPatterns)){
                $usedPatterns[$pattern]=true;
                $text = str_replace($pattern, '<a href="' . $pattern . '" rel="nofollow" target="_blank">' . $pattern . '</a>', $text);
            }
        }

        //twitter hashtags
        preg_match_all("/([#]{1})(\w+)/", $text, $matches);
        if (isset($matches[2]) && is_array($matches[2])) {
            $usedPatterns = array();
            foreach ($matches[2] as $match) {
                if(!array_key_exists($match, $usedPatterns)) {
                    $usedPatterns[$match]=true;
                    $text = str_replace('#' . $match, '<a href="https://twitter.com/hashtag/' . $match . '?src=hash" target="_blank">#' . $match . '</a>', $text);
                }
            }
        }

        return $text;
    }
}
