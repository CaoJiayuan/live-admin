/**
 * Created by d on 17-4-27.
 */
import {removeQuery, toastrNotification, postForm, setQuery, upload, deleteAlert} from "./app/utils";
require('./bootstrap');
require('sweetalert');
require('./app/vue');
window.toastr  = require('toastr');
window.sprintf = require('./app/sprintf');
require('./app/table');
require('./app/delete');
require('./app/fliter');
window.toastrNotification = toastrNotification;
window.postForm           = postForm;
window.setQuery           = setQuery;
window.upload             = upload;
window.deleteAlert        = deleteAlert;
$(document).ready(function () {
  $('.i-checks').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass   : 'iradio_square-green',
  });
  $('.navbar-minimalize').click(function () {
    axios.get('/nav/toggle')
  });
  $('.search button[type=reset]').click(function () {
    window.location.href = removeQuery(window.location.href, 'keyword')
  });
  new DataTable().sorting();
});