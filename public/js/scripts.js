$(document).ready(function() {
  setScrolls();
  setMenuMobile();
  setDataTable();
  setDatePicker();
});

const sweetDelete = (title, text, url) =>{
	swal({
		title: title,
		html: text,
		type: 'error',
		showCancelButton: true,
		allowOutsideClick: false,
		confirmButtonColor: '#3490DC',
		cancelButtonColor: '#6C757D',
		confirmButtonText: 'Sim',
		cancelButtonText: 'Não'
	}).then((result) => {
		if (result.value) {
			window.location = url;
		}
	})
}




const setScrolls = () => {
  $("#app-sidebar__content").mCustomScrollbar({
    theme: "minimal-dark",
  });
}


const setMenuMobile = () => {
  $(".app-sidebar__toggle-button").on('click', function(e) {
    e.preventDefault();
    $('.app-sidebar').toggleClass('app-sidebar--visible');
  });
}



const setDataTable = () => {

  $('.datatables').dataTable({
    "order": [],
    "language": {
      "url": "dt/Portuguese-Brasil.json"
    },
  });
};



let userId
let userName
let userQtdLead

const handleUserDeletePopup = (id, name, qtdLead) => {
  $('#form-move-lead').trigger("reset");
  userId = id;
  userName = name;
  userQtdLead = qtdLead;
  $('#user-name').html(name);
  $('#user-qtd-leads').html(qtdLead);
  $('#user_id').val(id);

  $('.user-delete__popup').fadeIn();
}

const handleClosePopup = () => {
  $('.user-delete__popup').fadeOut();
}







const sweetUserDelete = (url) =>{
	swal({
		title: 'Apagar usuário',
		html: 'Deseja realmente apagar o usuário '+userName+' <br/>e todos seus '+userQtdLead+' leads ?',
		type: 'error',
		showCancelButton: true,
		allowOutsideClick: false,
		confirmButtonColor: '#3490DC',
		cancelButtonColor: '#6C757D',
		confirmButtonText: 'Sim',
		cancelButtonText: 'Não'
	}).then((result) => {
		if (result.value) {
			window.location = url + '/'+userId;
		}
	})
}



function setDatePicker() {
  var dateFormat = "dd/mm/yy",
    from = $("#from")
    .datepicker({
      dateFormat: 'dd/mm/yy',
      defaultDate: "+1w",
      dayNames: ['Domingo', 'Segunda', 'TerÃ§a', 'Quarta', 'Quinta', 'Sexta', 'SÃ¡bado'],
      dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
      dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'SÃƒÂ¡b', 'Dom'],
      monthNames: ['Janeiro', 'Fevereiro', 'MarÃ§o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
      nextText: 'PrÃ³ximo',
      prevText: 'Anterior',
    })
    .on("change", function() {
      to.datepicker("option", "minDate", getDate(this));
    }),
    to = $("#to").datepicker({
      dateFormat: 'dd/mm/yy',
      defaultDate: "+1w",
      dayNames: ['Domingo', 'Segunda', 'TerÃ§a', 'Quarta', 'Quinta', 'Sexta', 'SÃ¡bado'],
      dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
      dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'SÃ¡b', 'Dom'],
      monthNames: ['Janeiro', 'Fevereiro', 'MarÃ§o', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
      monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
      nextText: 'PrÃ³ximo',
      prevText: 'Anterior',
    })
    .on("change", function() {
      from.datepicker("option", "maxDate", getDate(this));
    });


  function getDate(element) {
    var date;
    try {
      date = $.datepicker.parseDate(dateFormat, element.value);
    } catch (error) {
      date = null;
    }

    return date;
  }
};



const handleCloseFunnelPopup = () => {
  $('.funnel-popup').fadeOut();
}


const generatetSigla = (name) => {
  let p = name.toUpperCase();
  p = p.split(' ');
  if (p.length > 1) {
    const p1 = p[0].substring(0, 1);
    const p2 = p[1].substring(0, 1);
    return (p1 + p2);
  } else {
    const p1 = p[0].substring(0, 2);
    return p1;
  }
}


let isemptytHistoric = 0;
const handleLoadLeadInfo = (url) =>{
  $.ajax({
    type: "GET",
    url: url,
    timeout: 5000,
    contentType: "application/json; charset=utf-8",
    cache: false,
    beforeSend: function() {
      $('.funnel-loading-popup').fadeIn();
    },
    error: function() {
      $('.funnel-loading-popup').fadeOut();
      alert("Ocorreu um erro, por favor, recarregue a página")
    },
    success: function(data) {
      $('#lead_id').val(data.id);
      $('#lead-sigla').html(data.name && generatetSigla(data.name));
      $('#lead-nome').html(data.name);
      $('#lead-email').html(data.email);
      $('#lead-fone').html(data.phone);
      $('#lead-cpf').html(data.cpf);
      $('#lead-data-nasc').html(data.birthdate);
      $('#lead-renda').html(data.income);
      $('#lead-mensagem').html(data.comments);

      $('.funnel-loading-popup').hide();
      $(".message-historic").animate({ scrollTop: 0 });
      $('.funnel-popup').show();

      const targetList = $("#timeline-box");
      targetList.empty();
      isemptytHistoric = ! data.historics.length;

      data.historics.map( h => {
        targetList.append(
          "<div class='timeline-vertical-item'> "+
          "<div class='timeline-vertical-item-user'>"+
            "<span></span>"+
          "</div>"+
          "<div class='timeline-vertical-item-balao'>"+
            "<div class='timeline-vertical-item-balao-content'>"+
              "<p>"+h.user.name+" <span>("+h.user.privilege.name+")</span></p>"+
              "<p>"+h.message.replaceAll('\n', '<br/>')+"</p>"+
              "<p class='data-acao'><i class='far fa-clock'></i> "+dateFns.format(
                new Date(h.created_at),
                "DD/MM/YYYY [às] HH:mm",
              )+"</p>"+
            "</div></div></div>"
        )
      })

      if(isemptytHistoric){
        targetList.append(
          "<div class='timeline-vertical-item'> "+
          "<div class='timeline-vertical-item-user'>"+
            "<span></span>"+
          "</div>"+
          "<div class='timeline-vertical-item-balao'>"+
            "<div class='timeline-vertical-item-balao-content'>"+
              "<p>Nenhuma mensagem encontrada</p>"+
              "<p class='data-acao'></p>"+
            "</div></div></div>"
        )
      }

    }
  })


}


const handleSendMessage = (url) =>{
  const message = $('#message').val().trim();
  const lead_id = $('#lead_id').val();
  if(message.length > 0){
    $('#message').val('');
    const dataToSend = {
      lead_id,
      message,
    };
    $.ajax({
      type: "POST",
      url: url,
      timeout: 5000,
      data: dataToSend,
      cache: false,
      error: function(error) {
        console.log(error)
        alert("Ocorreu um erro, por favor, recarregue a página")
      },
      success: function(data) {
        const targetList = $("#timeline-box");
        if(isemptytHistoric){
          targetList.empty();
          isemptytHistoric = false;
        }
        targetList.prepend(
          "<div class='timeline-vertical-item'> "+
          "<div class='timeline-vertical-item-user'>"+
            "<span></span>"+
          "</div>"+
          "<div class='timeline-vertical-item-balao'>"+
            "<div class='timeline-vertical-item-balao-content'>"+
              "<p>"+data.user.name+" <span>("+data.user.privilege.name+")</span></p>"+
              "<p>"+data.message.replaceAll('\n', '<br/>')+"</p>"+
              "<p class='data-acao'><i class='far fa-clock'></i> "+
              dateFns.format(
                new Date(data.created_at),
                "DD/MM/YYYY [às] HH:mm",
              )
              +"</p>"+
            "</div></div></div>"
        )

        $(".message-historic").animate({ scrollTop: 0 });
      }
    })
  }


}
