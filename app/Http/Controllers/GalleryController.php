<?php

namespace App\Http\Controllers;

use Storage;
use App\Album;
use App\Gallery;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class GalleryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function galleryList() {
        $galleries = Gallery::all();

        return view('gallery.list', compact(
            'galleries'
        ));
    }

    public function albumList(Gallery $gallery) {
        $albums = $gallery->albums;

        return view('gallery.album.list', compact(
            'gallery',
            'albums'
        ));
    }

    public function imagesList(Gallery $gallery, Album $album) {
        $images = $album->images;

        return view('gallery.album.images', compact(
            'gallery',
            'album',
            'images'
        ));
    }

    /**
     * Admin gallery list view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminGalleryList() {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        $galleries = Gallery::all();

        return view('admin.gallery.list', compact(
            'galleries'
        ));
    }

    /**
     * Admin gallery add view.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminGalleryAdd() {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        return view('admin.gallery.add');
    }

    /**
     * Admin gallery add validation and create function.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminGalleryAddPost(Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        $rules = [
            'title' => 'required|max:255',
            'subtitle' => 'max:255'
        ];

        $messages = [
            'title.required' => 'Bitte gebe einen Titel an.',
            'title.max' => 'Der Titel darf nicht länger als 255 Zeichen lang sein.',
            'subtitle.max' => 'Der Untertitel darf nicht länger als 255 Zeichen lang sein.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('admin.gallery.add'))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $gallery = new Gallery([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'slug' => str_slug($request->title),
                'description' => $request->description
            ]);
            $gallery->save();

            flash('Die Galerie wurde angelegt.', 'success');
            return redirect(route('admin.gallery.list'));
        }
    }

    /**
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminGalleryEdit(Gallery $gallery) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        return view('admin.gallery.edit', compact([
            'gallery'
        ]));
    }

    /**
     * @param Gallery $gallery
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminGalleryUpdate(Gallery $gallery, Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        $rules = [
            'title' => 'required|max:255',
            'subtitle' => 'max:255'
        ];

        $messages = [
            'title.required' => 'Bitte gebe einen Titel an.',
            'title.max' => 'Der Titel darf nicht länger als 255 Zeichen lang sein.',
            'subtitle.max' => 'Der Untertitel darf nicht länger als 255 Zeichen lang sein.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('admin.gallery.edit', [$gallery]))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $gallery->title = $request->title;
            $gallery->subtitle = $request->subtitle;
            $gallery->description = $request->description;
            $gallery->save();

            flash('Die Galerie wurde aktualisiert.', 'success');
            return redirect(route('admin.gallery.list'));
        }
    }

    /**
     * Delete a gallery.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminGalleryDelete(Request $request) {
        //find gallery
        $gallery = Gallery::findOrFail($request->gallery_id);
        if ($gallery instanceof Gallery) {
            $gallery->delete();

            flash('Die Galerie wurde gelöscht.', 'success');
        }
        else {
            flash('Die Galerie wurde nicht gefunden.', 'danger');
        }

        return redirect(route('admin.gallery.list'));
    }

    /**
     * Admin gallery album list function.
     *
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminAlbumList(Gallery $gallery) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        $albums = $gallery->albums;

        return view('admin.gallery.album.list', compact(
            'gallery',
            'albums'
        ));
    }

    /**
     * @param Gallery $gallery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminAlbumAdd(Gallery $gallery) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        return view('admin.gallery.album.add', compact(
            'gallery'
        ));
    }

    /**
     * @param Gallery $gallery
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminAlbumAddPost(Gallery $gallery, Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        $rules = [
            'title' => 'required|max:255',
            'subtitle' => 'max:255'
        ];

        $messages = [
            'title.required' => 'Bitte gebe einen Titel an.',
            'title.max' => 'Der Titel darf nicht länger als 255 Zeichen lang sein.',
            'subtitle.max' => 'Der Untertitel darf nicht länger als 255 Zeichen lang sein.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('admin.gallery.album.add'))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $album = new Album([
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'slug' => str_slug($request->title),
                'description' => $request->description
            ]);

            $gallery->albums()->save($album);

            // create folders
            Storage::disk('galleries')->makeDirectory($gallery->id . '/' . $album->id . '/small/');

            flash('Das Album wurde angelegt.', 'success');
            return redirect(route('admin.gallery.album.list', [$gallery]));
        }
    }

    /**
     * @param Gallery $gallery
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminAlbumEdit(Gallery $gallery, Album $album) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        return view('admin.gallery.album.edit', compact(
            'gallery',
            'album'
        ));
    }

    /**
     * @param Gallery $gallery
     * @param Album $album
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminAlbumUpdate(Gallery $gallery, Album $album, Request $request) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        $rules = [
            'title' => 'required|max:255',
            'subtitle' => 'max:255'
        ];

        $messages = [
            'title.required' => 'Bitte gebe einen Titel an.',
            'title.max' => 'Der Titel darf nicht länger als 255 Zeichen lang sein.',
            'subtitle.max' => 'Der Untertitel darf nicht länger als 255 Zeichen lang sein.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return redirect(route('admin.gallery.album.edit', [$gallery, $album]))
                ->withErrors($validator)
                ->withInput();
        }
        else {
            $album->title = $request->title;
            $album->subtitle = $request->subtitle;
            $album->description = $request->description;
            $album->save();

            flash('Das Album wurde aktualisiert.', 'success');
            return redirect(route('admin.gallery.album.list', [$gallery]));
        }
    }

    /**
     * @param Gallery $gallery
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminAlbumDelete(Gallery $gallery, Request $request) {
        //find album
        $album = Album::findOrFail($request->album_id);
        if ($album instanceof Album) {
            $album->delete();

            flash('Das Album wurde gelöscht.', 'success');
        }
        else {
            flash('Das Album wurde nicht gefunden.', 'danger');
        }

        return redirect(route('admin.gallery.album.list', [$gallery]));
    }

    /**
     * @param Gallery $gallery
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminPicturesList(Gallery $gallery, Album $album) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        return view('admin.gallery.album.pictures.list', compact(
            'gallery',
            'album'
        ));
    }

    /**
     * @param Gallery $gallery
     * @param Album $album
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminPicturesEdit(Gallery $gallery, Album $album, Request $request) {
        if (is_array($request->title)) {
            foreach ($request->title as $id=>$value) {
                $image = \App\Image::find($id);
                if ($image instanceof \App\Image) {
                    $image->caption = trim($value);
                    $image->save();
                }
            }
        }

        flash('Änderungen wurden gespeichert.', 'success');
        return redirect(route('admin.gallery.album.pictures.list', [$gallery, $album]));
    }

    /**
     * @param Gallery $gallery
     * @param Album $album
     * @param \App\Image $image
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function adminPicturesDelete(Gallery $gallery, Album $album, \App\Image $image) {
        if ($image instanceof \App\Image) {
            $image->delete();
            flash('Das Bild wurde gelöscht.', 'success');
        }

        return redirect(route('admin.gallery.album.pictures.list', [$gallery, $album]));
    }

    /**
     * @param Gallery $gallery
     * @param Album $album
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
     */
    public function adminPicturesAdd(Gallery $gallery, Album $album) {
        if (!Auth::check() || !Auth::user()->hasRole('imagemanager')) {
            return redirect(route('home'));
        }

        return view('admin.gallery.album.pictures.add', compact(
            'gallery',
            'album'
        ));
    }

    /**
     * @param Gallery $gallery
     * @param Album $album
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function adminPicturesUpload(Gallery $gallery, Album $album, Request $request) {
        $image = Input::file('file');

        // check image
        if ($image instanceof UploadedFile) {

            if ($image->getError() != 0) {
                return response()->json([$image->getErrorMessage()], 400);
            }

            if (!$image->isFile()) {
                return response()->json(['Bitte nur Bild-Daten hochladen!'], 400);
            }

            if (!$image->isValid()) {
                return response()->json(['Datei konnte nicht gelesen werden!'], 400);
            }

            // get original width and height
            list($width, $height) = getimagesize($image);

            // init new values
            $ratio = 1;
            $newWidth = $width;
            $newHeight = $height;

            if ($width > 1024) {
                $newWidth = 1024;
                $ratio = $height / $width;
                $newHeight = $ratio * 1024;
            }

            if ($newHeight > 1024) {
                $newHeight = 1024;
                $ratio = $width / $height;
                $newWidth = $ratio * 1024;
            }

            // path and new filename
            $path = $gallery->id . DIRECTORY_SEPARATOR . $album->id . DIRECTORY_SEPARATOR;
            $fullpath = public_path() . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR . 'galleries' . DIRECTORY_SEPARATOR . $path;
            $filename = sha1(time() . time()) . '.' .strtolower($image->getClientOriginalExtension());

            // create resized image and save it
            Image::make($image->getRealPath())->resize($newWidth, $newHeight)->save($fullpath . $filename, 60);
            Image::make($image->getRealPath())->resize(200, 200 * $ratio)->save($fullpath . 'small' .  DIRECTORY_SEPARATOR . $filename, 60);

            // create new image relation to album
            $img = new \App\Image([
                'filename' => $filename
            ]);
            $album->images()->save($img);

            // return success
            return response()->json(['success'], 200);
        }

        // return error
        return response()->json(['error'], 400);
    }
}