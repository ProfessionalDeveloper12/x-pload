function Main(){
    var self = this;
    this.init = function(){
        // call Function
        self.scroll();
    };
    
    this.scroll = function(){
        $(document).on('click','header li a',function(){
            _that = $(this);
            _id = _that.attr("href");
            if(_id!= undefined) {
                $('html, body').animate({
                    scrollTop: $(_id).offset().top
                }, 1000);
            }
        });
    };
}

Main= new Main();
$(function(){
    Main.init();
});
