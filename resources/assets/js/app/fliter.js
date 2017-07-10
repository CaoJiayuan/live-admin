/**
 * Created by d on 17-5-23.
 */
import {sprintf} from './sprintf'
import {setQuery, parseUrl} from './utils'
var _ = require("lodash");
(function (window, $) {
  function Filter() {
    this.$area = $('#area-filter');
    this.$room = $('#room-filter');
    this.onRoom = id => {};
  }

  Filter.prototype.init = function (onroom) {
    this.onRoom = onroom || function () {};
    this.getAreas();
    this.onAreaChange();
    this.onRoomChange();
  };

  Filter.prototype.onAreaChange = function () {
    this.$area.change(e => {
      this.getRooms(this.$area.val());
    })
  };
  Filter.prototype.onRoomChange = function () {
    this.$room.change(e => {
      this.setRoom();
    })
  };

  Filter.prototype.setRoom = function () {
    this.onRoom(this.$room.val())
  };

  Filter.prototype.getRooms = function (areaId) {
    areaId = areaId || 0;
    $.get('/api/filter/' + areaId + '/rooms', data => {
      var ops = '';
      if (_.isArray(data)) {
        data.forEach(item => {
          ops += sprintf('<option value="%s">%s</option>', item.id, item.title)
        });
      }
      this.$room.html(ops);
      this.setRoom();
    })
  };

  Filter.prototype.getAreas = function () {
    $.get('/api/filter/areas', data => {
      var ops = '';
      if (_.isArray(data)) {
        data.forEach(item => {
          ops += sprintf('<option value="%s">%s</option>', item.id, item.name)
        });
      }
      this.$area.html(ops);
      this.getRooms(this.$area.val())
    })
  };

  window.Filter = Filter;
})(window, jQuery);