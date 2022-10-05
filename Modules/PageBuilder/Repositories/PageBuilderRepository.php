<?php


namespace Modules\PageBuilder\Repositories;


use Modules\FrontendManage\Entities\FrontPage;

class PageBuilderRepository
{

    public function designUpdate(array $data,$id)
    {
        return FrontPage::where('id',$id)->update([
            'details'  =>$data['body'],
        ]);
    }


}
