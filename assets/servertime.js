(function($) {
    $.fn.servertime = function(time, format) {
        var $this = this;
        
        if (!format)
            format = 'm-d-Y H:i:s';
        
        time.days = [0, 31, (time.Y % 4 ? 28 : (time.Y % 100 ? (time.Y % 400 ? 29 : 28) : 29)), 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        function tick() {
            (++time.s >= 60) && ((time.s = 0) || ++time.i >= 60) && ((time.i = 0) || ++time.H >= 24) && ((time.H = 0) || ++time.d >= time.days[time.m]) && ((time.d = 1) && ++time.m >=12) && ((time.m = 1) && ++time.Y) && alert('Happy new year!');
            
            var g = (time.H % 12 == 0) ? 12 : time.H % 12;
            
            var formatted = {
                d: (time.d < 10 ? '0' : '') + time.d,
                m: (time.m < 10 ? '0' : '') + time.m,
                Y: time.Y,
                g: g,
                G: time.H,
                h: (g < 10 ? '0' : '') + g,
                H: (time.H < 10 ? '0' : '') + time.H,
                i: (time.i < 10 ? '0' : '') + time.i,
                s: (time.s < 10 ? '0' : '') + time.s,
                a: time.H < 12 ? 'am' : 'pm',
                A: time.H < 12 ? 'AM' : 'PM'
            };
            var str = format;
            
            for (key in formatted) {
                str = str.replace(key, formatted[key]);
            }
            
            $this .text( str );
        }
        window.setInterval(tick, 1000)
    };  
})(jQuery); 