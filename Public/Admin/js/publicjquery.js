$(function(){
       
        //左侧菜单
        $(".nav-first li").children(".first").click(function(){
            if($(this).parent("li").hasClass("active")){
                $(this).parent("li").removeClass("active").find("ul").slideUp(800);
                $('.nav-first .down').show();
                $('.nav-first .up').hide();
                $(this).children('.down').show();
                $(this).children('.up').hide();
            }else{
                $(".nav-first li").removeClass("active").find("ul").slideUp(800);
                $(this).parent("li").addClass("active").find("ul").slideDown(800);
                $('.nav-first .down').show();
                $('.nav-first .up').hide();
                $(this).children('.down').hide();
                $(this).children('.up').show();
            }
        });
        $(".nav-second li a").click(function(){
            $(".nav-second li a").removeClass("active");
            $(this).addClass("active");
        });

        // select模拟
        $(".select-content").click(function(){
            if($(this).siblings("ul").css("display")=="none"){
                $(this).siblings("ul").slideDown("fast");
            }else{
                $(this).siblings("ul").slideUp("fast");
            } 
        });
        $(".option li").click(function(){
            $(this).parent().slideUp("fast").siblings(".select-content").children("span").text($(this).text());
        });

        // 高级
        $(".senior").click(function(){
            if($(".senior-content").css("display")=="none"){
                $(".senior-content").slideDown();
                $(this).children("i").html("&#xe606;");
            }else{
                $(".senior-content").slideUp();
                $(this).children("i").html("&#xe655;");
            }
        });

        //弹出搜索
        /* $(".search-icon").click(function(){
            $(".head-search .select").show();
            $(".head-search .search").removeClass("no-border");
            $(".head-search .search").find("input").show();
            $(this).removeClass("color-999999");
        }); */

        //开关
        $(".switch").click(function(){
            if($(this).hasClass("active")){
                $(this).removeClass("active");
            }else{
                $(this).addClass("active");
            }
        });
        $(".switch2").click(function(){
            if($(this).hasClass("active")){
                $(this).removeClass("active");
                $(this).children("span").text("OFF");
            }else{
                $(this).addClass("active");
                $(this).children("span").text("ON");
            }
        })

        //关闭弹窗
        $(".notice-head-delete,.btn-drop").click(function(){
            $(".pop-window").fadeOut("fast");
        })

        //
        
       

        //
        

        //
        


    })