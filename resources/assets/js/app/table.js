import {setQuery,parseUrl} from './utils';
(function (window) {
    function DataTable() {
        this.nowAsc = true;
        this.der = '';
        this.col  = '';
        let urlData = parseUrl(window.location.href);
        if (urlData.query.hasOwnProperty('sort')) {
            let der = urlData.query.sort.split('|')[1] || 'asc';
            let col = urlData.query.sort.split('|')[0] || 'id';
            der == 'asc' && (this.nowAsc = false);
            this.col  = col;
            this.der  = der;
        }
        this.url = window.location.href
    }

    DataTable.prototype.sorting = function () {
        let st = this.nowAsc ? 'asc' : 'desc';
        let the = this;
        let ele = $('.sorting');
        ele.each(function (item, a) {
            let self = $(this);
            if (self.data('column') == the.col) {
               self.addClass('sorting_' + the.der);
           }
        });
        ele.click(function () {
            let self = $(this);
            let col = self.data('column');
            self.removeClass('sorting_desc');
            self.removeClass('sorting_asc');
            self.addClass('sorting_' + st);
            window.location.href = setQuery(the.url, {
                sort: col + '|' + st
            });
        });
    };

    window.DataTable = DataTable;
})(window);