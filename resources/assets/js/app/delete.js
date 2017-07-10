/**
 * Created by d on 17-5-10.
 */
import {deleteAlert} from './utils';
$(document).ready(function () {
  $('.delete').click(function () {
    var url =  $(this).data('url')
    deleteAlert(url)
  })
});