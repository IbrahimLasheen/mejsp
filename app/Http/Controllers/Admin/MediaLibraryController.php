<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MediaLibrary;
use Illuminate\Http\Request;

class MediaLibraryController extends Controller
{

    // Uploads Paths
    const PATH = "assets/uploads/media-library/";
    const IMG_EXT = '.webp';
    const MAX_SIZE = 8388608; // 8MP
    const ALLOWED_EXT = ["jpeg", "jpg", "png", "webp", "bmp", "tiff", "svg"];

    public function index()
    {
        $media = MediaLibrary::orderBy("id", "DESC")->paginate(100);
  
        return view("admin.media.all", compact('media'));
    }


    public function create()
    {
        return view("admin.media.create");
    }


    public function store(Request $request)
    {


        if (count($request->image) > 10) {
            echo "<div class='box-error'>الحد الاقصي للرفع 10 صور</div>";
        } else {

            for ($i = 0; $i < count($request->image); $i++) {
                $img         = $request->image[$i];
                $imgName     = $img->getClientOriginalName();
                $imgRealPath = $img->getRealPath();
                $imgExt      = $img->extension();

                // Image Size
                $imgSize   = $_FILES['image']['size'][$i];

                // Check IF Allowed Ext Isset
                if (in_array($imgExt, self::ALLOWED_EXT)) {

                    // Check Image Size
                    if ($imgSize < self::MAX_SIZE) {


                        $newImgName = randomName(self::IMG_EXT);
                        $insert = MediaLibrary::create([
                            'image' => $newImgName
                        ]);
                        if ($insert->save()) {
                            echo "<div class='box-success'> تم رفع  <b>" . $imgName . "</b> بنجاح</div>";
                            image($img, self::PATH, $newImgName, 800, 600);
                        }
                    } else {
                        echo "<div class='box-error'> حجم  <b>" . $imgName . "</b> ضخم جدا الحد الاقصي 8 ميجابايت</div>";
                    }
                } else {
                    echo "<div class='box-error'> امتداد  <b>" . $imgName . "</b> غير مسموح به</div>";
                }
            }
        }
    }


    public function destroy(Request $request)
    {
        $row = MediaLibrary::find($request->id);
        if (!empty($row)) {
            // Delete File
            @unlink(self::PATH . $row->image);
            // Delete Row From DB
            $row->delete();
            // Message
            $request->session()->flash('deleteMessage', 'تم حذف الصورة بنجاح');
        }
        return back();
    }
}
