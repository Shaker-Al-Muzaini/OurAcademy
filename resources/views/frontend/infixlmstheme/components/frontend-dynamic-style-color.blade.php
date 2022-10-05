<div>
    <style>
        :root {
            --system_primery_color: {{$color->primary_color??'#FB1159' }};
            --system_secendory_color: {{$color->secondary_color??'#202E3B' }} ;
            --footer_background_color: {{$color->footer_background_color??'#1E2147' }} ;
            --footer_headline_color: {{$color->footer_headline_color??'#ffffff' }} ;
            --footer_text_color: {{$color->footer_text_color??'#5B5C6E' }} ;
            --footer_text_hover_color: {{$color->footer_text_hover_color??'#FB1159' }} ;

            --menu_bg: {{Settings('menu_bg')?Settings('menu_bg'):'#f8f9fa'}};
            --menu_text: {{Settings('menu_text')?Settings('menu_text'):'#2b3d4e'}} ;
            --menu_hover_text: {{Settings('menu_hover_text')?Settings('menu_hover_text'):'#FB1159'}};
            --menu_title_text: {{Settings('menu_title_text')?Settings('menu_title_text'):'#202E3B'}} ;
        }
    </style>
</div>
