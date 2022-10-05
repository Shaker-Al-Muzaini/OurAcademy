<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Language;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Setting\Model\GeneralSetting;
use Modules\RolePermission\Entities\RolePermission;


class FrontendHomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('maintenanceMode');
    }

    public function index()
    {

        try {
            if (!\auth()->check()) {
                if (Settings('start_site') == 'loginpage') {
                    return redirect()->route('login');
                }
            }
            if (function_exists('SaasDomain')) {
                $domain = SaasDomain();
            } else {
                $domain = 'main';
            }
            $blocks = Cache::rememberForever('homepage_block_positions' . $domain, function () {
                return DB::table('homepage_block_positions')->select(['id', 'block_name', 'order'])->orderBy('order', 'asc')->get();
            });

            return view(theme('pages.index'), compact('blocks'));
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function test()
    {
        $domain = session()->get('domain') ?? 'main';
        $path = Storage::path('settings.json');
        $settings = GeneralSetting::get(['key', 'value'])->pluck('value', 'key')->toArray();
        $strJsonFileContents = file_get_contents($path);
        $file_data = json_decode($strJsonFileContents, true);
        $setting_array[$domain] = $settings;
        $merged_array = array_merge($file_data, $setting_array);
        $merged_array = json_encode($merged_array, JSON_PRETTY_PRINT);
        file_put_contents($path, $merged_array);

        return file_get_contents($path);
    }
}
