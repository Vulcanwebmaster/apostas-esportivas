<?php

/* website/page/aposta.twig */
class __TwigTemplate_b23aa6375d8ddbf46e43b5e179b535e66bfa1b995c162334285550216ec3b488 extends Twig_Template
{
    private $source;

    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        // line 1
        $this->parent = $this->loadTemplate("website/layout.twig", "website/page/aposta.twig", 1);
        $this->blocks = array(
            'bilhete' => array($this, 'block_bilhete'),
            'jogos' => array($this, 'block_jogos'),
            'main' => array($this, 'block_main'),
            'script' => array($this, 'block_script'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "website/layout.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_bilhete($context, array $blocks = array())
    {
        // line 4
        echo "    <div class=\"bilhete rounded pb-1\">

        <h3 class=\"title rounded-top\">
            <i class=\"fa fa-file-text-o\"></i> Bilhete
        </h3>

        <div class=\"lista-jogos\" style=\"min-height: 250px;\">
            <div v-if=\"aposta.jogos.length < minJogos\">
                <div class=\"alert alert-warning m-0 rounded-0\">
                    Mínimo de jogos: \${minJogos}
                </div>
            </div>
            <div v-if=\"aposta.jogos.length\">
                <table class=\"table table-striped table-hover table-aposta mb-0\">
                    <tbody>
                    <tr class=\"tabelaBilheteTitulo\">
                        <td>Jogos</td>
                        <td width=\"1px\"></td>
                    </tr>
                    <tr v-for=\"(v, i) in aposta.jogos\">
                        <td>
                            <div>
                                <b>\${v.jogo.casa}</b> x <b>\${v.jogo.fora}</b>
                            </div>
                            <div>
                                \${v.jogo.data.split('-').reverse().join('/')} às \${v.jogo.hora.replace(/:00\$/, '')}
                            </div>
                            <div>
                                \${v.cotacao.sigla} - Taxa:
                                \${v.jogo.cotacoes[v.tempo][v.cotacao.campo]|maskReal}
                                <div class=\"d-inline\" v-if=\"v.tempo != '90'\">
                                    \${v.tempo == 'pt' ? 'Primeiro tempo': 'Segundo tempo'}
                                </div>
                            </div>
                        </td>
                        <td width=\"5\">
                            <a href=\"javascript:;\" v-on:click=\"rmAposta(i)\"
                               class=\"text-danger\">
                                <i class=\"fa fa-times\" style=\"font-size: 15px;\"></i>
                            </a>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class=\"container-fluid\">

            <div style=\"font-size: 14px;\" class=\"pt-2\">
                <div class=\"row align-items-center\">
                    <div class=\"col-auto form-group\">
                        Número de jogos
                    </div>
                    <div class=\"col text-right form-group\">
                        \${aposta.jogos.length}
                    </div>
                </div>
                <div class=\"row align-items-center\">
                    <div class=\"col-auto form-group\">
                        Valor da aposta
                    </div>
                    <div class=\"col form-group\">
                        <input type=\"number\" v-model=\"valorAposta\" v-bind:min=\"apostaMinima\"
                               v-bind:max=\"apostaMaxima\" step=\"1.00\"
                               class=\"form-control form-control-sm\"/>
                    </div>
                </div>
                <div class=\"row align-items-center\">
                    <div class=\"col-auto form-group\">
                        Valor do prêmio
                    </div>
                    <div class=\"col form-group text-right\">
                        R\$ \${premio}
                    </div>
                </div>
                <div class=\"row align-items-center\">
                    <div class=\"col-auto form-group\">
                        Cliente
                    </div>
                    <div class=\"col form-group\">
                        <input type=\"text\" v-model=\"cliente\"
                               class=\"form-control form-control-sm\"
                               placeholder=\"opcional\" maxlength=\"50\"/>
                    </div>
                    <div class=\"col-12 mb-2\">
                        <div class=\"row\">
                            <div class=\"col-6\">
                                <button class=\"btn btn-sm btn-block btn-danger\"
                                        v-bind:disabled=\"!apostaValida\"
                                        v-on:click=\"finalizarAposta\">
                                    ";
        // line 95
        echo ((($context["user"] ?? null)) ? ("Concluír") : ("Pré-bilhete"));
        echo "
                                </button>
                            </div>
                            <div class=\"col-6\">
                                <button class=\"btn btn-sm btn-block btn-default\"
                                        v-on:click=\"limpaAposta\">
                                    Limpar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
";
    }

    // line 113
    public function block_jogos($context, array $blocks = array())
    {
        // line 114
        echo "
    <div class=\"table-responsive\" style=\"max-height: 600px;\" v-if=\"paises\">
        <table class=\"table table-jogos table-striped table-hover\" v-for=\"pais in paises\"
               v-if=\"filterPais(pais)\">
            <thead>
            <tr class=\"tr-header\">
                <th>Jogos</th>
                <th class=\"th-cotacao\" v-for=\"c in getCotacoesPrincipais()\">
                    <div v-bind:title=\"c.title\" data-toggle=\"tooltip\">
                        \${c.title}
                    </div>
                </th>
                <th class=\"th-cotacao\">Outras</th>
            </tr>
            <tr class=\"tr-pais\">
                <th colspan=\"10\">
                    <img v-bind:src=\"pais.img\"/> \${pais.title}
                </th>
            </tr>
            </thead>

            <tbody v-for=\"campeonato in getCampeonatos(pais)\">

            <tr class=\"campeonato\">
                <td colspan=\"10\">
                    <a href=\"javascript:;\" v-on:click=\"setCampeonato(campeonato)\">\${campeonato.title}</a>
                </td>
            </tr>

            <tr v-for=\"jogo in getJogos(campeonato)\">
                <td>
                    <div class=\"text-truncate\"><b>\${jogo.casa} x
                            <div>\${jogo.fora}</div>
                        </b></div>
                    <small>\${jogo.data.split('-').reverse().join('/')} às \${jogo.hora.replace(/:00\$/, '')}</small>
                </td>
                <td class=\"text-center\" v-for=\"c in getCotacoesPrincipais()\">
                    <div class=\"btn-cotacao\" v-bind:class=\"{active: jogo.apostaEm == '90' + c.campo}\"
                         v-bind:title=\"c.title\"
                         data-toggle=\"tooltip\"
                         v-on:click=\"apostar(jogo, '90', c)\">
                        \${jogo.cotacoes['90'][c.campo]|maskReal}
                    </div>
                </td>
                <td>
                    <div class=\"btn-cotacao outras\" data-toggle=\"tooltip\" title=\"Outras cotações\"
                         v-bind:class=\"{active: jogo.outras}\" v-on:click=\"maisCotacoes(jogo)\">
                        +\${totalCotacoes(jogo.cotacoes)-getCotacoesPrincipais().length}
                    </div>
                </td>
            </tr>

            </tbody>

        </table>
    </div>

    <div id=\"modal-cotacoes\" class=\"modal fade\">
        <div class=\"modal-dialog modal-lg\">
            <div class=\"modal-content\">
                <div class=\"modal-header\">
                    <h3 class=\"modal-title\">Mais cotações</h3>
                    <div class=\"close\" data-dismiss=\"modal\">&times;</div>
                </div>
                <div class=\"modal-body p-0\">
                    <div class=\"p-3\">
                        <button type=\"button\" class=\"btn btn-danger btn-sm mr-1\"
                                v-bind:class=\"{active: key == mJogo.tempo || null}\"
                                v-for=\"(tempo, key) in tempos\" v-on:click=\"mJogo.tempo = key\">
                            \${tempo}
                        </button>
                    </div>
                    <div class=\"row m-0\" v-if=\"mJogo.jogo\">

                        <table class=\"table table-minified table-striped table-bordered m-0\">
                            <thead>
                            <tr class=\"bg-danger text-white\">
                                <th>Descrição</th>
                                <th width=\"120\">Taxa</th>
                            </tr>
                            </thead>
                        </table>

                        <table class=\"table table-minified table-striped table-bordered table-hover m-0\"
                               v-for=\"(grupo, id) in grupos\">
                            <thead>
                            <tr style=\"background-color: #bbb\">
                                <th colspan=\"2\">\${grupo}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for=\"c in cotacoes\"
                                v-if=\"c.grupo == id && mJogo.jogo.cotacoes[mJogo.tempo][c.campo] > 1\">
                                <td>\${c.title}</td>
                                <td class=\"text-center\" width=\"120\">
                                    <a href=\"javascript:;\" class=\"btn-cotacao\"
                                       v-bind:class=\"{active: mJogo.jogo.apostaEm == mJogo.tempo + c.campo }\"
                                       v-on:click=\"apostar(mJogo.jogo, mJogo.tempo, c)\">
                                        \${mJogo.jogo.cotacoes[mJogo.tempo][c.campo]|maskReal}
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

";
    }

    // line 227
    public function block_main($context, array $blocks = array())
    {
        // line 228
        echo "
    <h1 class=\"page-title\">Faça já sua aposta</h1>

    <div id=\"pg-aposta\">
        <div class=\"container-fluid pt-3\">
            <div class=\"row page-aposta\">
                <div class=\"";
        // line 234
        echo ((($context["responsive"] ?? null)) ? ("d-none d-md-block col-12 col-md-auto") : ("col-auto"));
        echo " mb-3\">
                    <div style=\"max-height: 760px; overflow: auto\">
                        <div class=\"campeonatos rounded\">
                            <h3 class=\"title\">Campeonatos</h3>
                            <ul>
                                <li class=\"campeonato\">
                                    <a href=\"javascript:;\" v-on:click=\"setCampeonato()\"
                                       v-bind:class=\"{ active: !checkFiltros() }\">
                                        Todos
                                    </a>
                                </li>
                                <li class=\"campeonato\">
                                    <a href=\"javascript:;\" v-on:click=\"setData('";
        // line 246
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-d"), "html", null, true);
        echo "')\"
                                       v-bind:class=\"{ active: findData == '";
        // line 247
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "Y-m-d"), "html", null, true);
        echo "' }\">
                                        Jogos de hoje (";
        // line 248
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "now", "d/m/Y"), "html", null, true);
        echo ")
                                    </a>
                                </li>
                                <li class=\"campeonato\">
                                    <a href=\"javascript:;\" v-on:click=\"setData('";
        // line 252
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "+1day", "Y-m-d"), "html", null, true);
        echo "')\"
                                       v-bind:class=\"{ active: findData == '";
        // line 253
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "+1day", "Y-m-d"), "html", null, true);
        echo "' }\">
                                        Jogos de amanhã (";
        // line 254
        echo twig_escape_filter($this->env, twig_date_format_filter($this->env, "+1day", "d/m/Y"), "html", null, true);
        echo ")
                                    </a>
                                </li>
                                <div v-for=\"(p, i) in paises\" v-bind:class=\"{last: i == paises.length - 1}\">
                                    <li class=\"campeonato pais\">
                                        <a href=\"javascript:;\" v-on:click=\"setPais(p)\"
                                           v-bind:class=\"{active: findPais == p.id}\">
                                            \${p.title}
                                        </a>
                                    </li>
                                    <li class=\"campeonato\" v-for=\"(c, i) in p.campeonatos\"
                                        v-bind:class=\"{last: i == p.campeonatos.length - 1}\">
                                        <a href=\"javascript:;\" v-on:click=\"setCampeonato(c)\"
                                           v-bind:class=\"{ active: findCampeonato == c.id }\">
                                            \${c.title}
                                        </a>
                                    </li>
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class=\"col\">
                    ";
        // line 277
        $this->loadTemplate("website/inc/slideshow.twig", "website/page/aposta.twig", 277)->display(array_merge($context, array("ref" => "site-slideshow")));
        // line 278
        echo "                    <div class=\"row\">
                        <div class=\"col mb-3\">

                            ";
        // line 281
        if (($context["responsive"] ?? null)) {
            // line 282
            echo "                                <div class=\"d-block d-md-none mb-3\">
                                    <label>Campeonatos</label>
                                    <select v-model=\"findCampeonato\" class=\"form-control\">
                                        <option value=\"*\">Todos</option>
                                        <optgroup v-for=\"p in paises\" label=\"p.title\">
                                            <option v-for=\"c in p.campeonatos\" v-bind:value=\"c.id\">\${c.title}</option>
                                        </optgroup>
                                    </select>
                                </div>
                            ";
        }
        // line 292
        echo "
                            ";
        // line 293
        $this->displayBlock("jogos", $context, $blocks);
        echo "

                        </div>
                        <div class=\"";
        // line 296
        echo ((($context["responsive"] ?? null)) ? ("col-12 col-md-auto") : ("col-auto"));
        echo " mb-3\">
                            ";
        // line 297
        $this->displayBlock("bilhete", $context, $blocks);
        echo "
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

";
    }

    // line 307
    public function block_script($context, array $blocks = array())
    {
        // line 308
        echo "
    ";
        // line 309
        if ((($context["isLocal"] ?? null) == 0)) {
            // line 310
            echo "        <script src=\"node_modules/vue/dist/vue.min.js\"></script>
    ";
        } else {
            // line 312
            echo "        <script src=\"node_modules/vue/dist/vue.js\"></script>
    ";
        }
        // line 314
        echo "    <script src=\"node_modules/axios/dist/axios.js\"></script>
    <script src=\"node_modules/lodash/lodash.min.js\"></script>

    <script type=\"text/javascript\">

        var app = new Vue({
            el: '#pg-aposta',
            delimiters: ['\${', '}'],
            created: function () {

                var _app = this;

                \$('html').addClass('loading');

                this.aposta.jogos.forEach(function (v, i) {
                    if (!_app.filterJogo(v.jogo)) {
                        _app.aposta.jogos.splice(i, 1);
                    }
                });

                axios
                    .get('apostar/jogos')
                    .then(function (response) {
                        _app.grupos = response.data.grupos;
                        _app.cotacoes = response.data.cotacoes;
                        _app.paises = response.data.paises;
                    })
                    .catch(function (error) {
                        console.log(error);
                    })
                    .then(function () {
                        \$('html').removeClass('loading');
                    });

            },
            data: {
                valorAposta: ";
        // line 350
        echo twig_escape_filter($this->env, call_user_func_array($this->env->getFunction('dados')->getCallable(), array("apostaminima")), "html", null, true);
        echo ",
                findCampeonato: '*',
                findData: null,
                findPais: '*',
                tempos: {90: 'Jogo completo', pt: 'Primeiro tempo', st: 'Segundo tempo'},
                cliente: '',
                grupos: {},
                mJogo: {
                    jogo: null,
                    tempo: 90,
                },
                cotacao: 0,
                cotacoes: [],
                paises: [],
                aposta: {
                    jogos: [],
                },
                cotacaoMaxima: ";
        // line 367
        echo twig_escape_filter($this->env, ((call_user_func_array($this->env->getFunction('dados')->getCallable(), array("cotacaomaxima"))) ? (call_user_func_array($this->env->getFunction('dados')->getCallable(), array("cotacaomaxima"))) : (99999999)), "html", null, true);
        echo ",
                cotacaoMinima: ";
        // line 368
        echo twig_escape_filter($this->env, ((call_user_func_array($this->env->getFunction('dados')->getCallable(), array("cotacaominima"))) ? (call_user_func_array($this->env->getFunction('dados')->getCallable(), array("cotacaominima"))) : (1)), "html", null, true);
        echo ",
                apostaMinima: ";
        // line 369
        echo twig_escape_filter($this->env, ((call_user_func_array($this->env->getFunction('dados')->getCallable(), array("apostaminima"))) ? (call_user_func_array($this->env->getFunction('dados')->getCallable(), array("apostaminima"))) : (1)), "html", null, true);
        echo ",
                apostaMaxima: ";
        // line 370
        echo twig_escape_filter($this->env, ((call_user_func_array($this->env->getFunction('dados')->getCallable(), array("apostamaxima"))) ? (call_user_func_array($this->env->getFunction('dados')->getCallable(), array("apostamaxima"))) : (999999)), "html", null, true);
        echo ",
                retornoMaximo: ";
        // line 371
        echo twig_escape_filter($this->env, ((call_user_func_array($this->env->getFunction('dados')->getCallable(), array("retornomaximo"))) ? (call_user_func_array($this->env->getFunction('dados')->getCallable(), array("retornomaximo"))) : (99999999)), "html", null, true);
        echo ",
                minJogos: ";
        // line 372
        echo twig_escape_filter($this->env, ((call_user_func_array($this->env->getFunction('dados')->getCallable(), array("minjogos"))) ? (call_user_func_array($this->env->getFunction('dados')->getCallable(), array("minjogos"))) : (1)), "html", null, true);
        echo ",
            },
            filters: {
                maskReal: function (value) {
                    if (!value) {
                        return '0,00';
                    } else {
                        return value.toString().toReal();
                    }
                }
            },
            computed: {
                premio: function () {

                    var valorAposta = this.valorAposta;
                    var cotacao = 1;

                    this.aposta.jogos
                        .forEach(function (v) {
                            cotacao *= v.jogo.cotacoes[v.tempo][v.cotacao.campo];
                        });

                    this.cotacao = Math.min(cotacao, this.cotacaoMaxima);

                    if (cotacao > 1) {
                        return (Math.min(valorAposta * this.cotacao, this.retornoMaximo)).toString().toReal();
                    } else {
                        return '0,00';
                    }

                },
                apostaValida: function () {
                    return this.aposta.jogos.length >= this.minJogos;
                }
            },
            methods: {
                getCotacoesPrincipais: function () {
                    var cotacoes = [];
                    if (this.cotacoes) {
                        this.cotacoes.forEach(function (c) {
                            if (c.principal == '1')
                                cotacoes.push(c);
                        });
                    }
                    return cotacoes;
                },
                totalCotacoes: function (cotacoes) {
                    var total = 0;

                    Object.values(cotacoes).forEach(function (c) {
                        Object.values(c).forEach(function (v) {
                            if (v > 1)
                                total++;
                        });
                    });

                    return total;
                },
                getPaises: function () {
                    var _app = this;
                    var paises = [];
                    this.paises.forEach(function (pais) {
                        if (_app.filterPais(pais)) {
                            paises.push(pais);
                        }
                    });
                    return paises;
                },
                getCampeonatos: function (pais) {
                    var _app = this;
                    var campeonatos = [];
                    pais.campeonatos.forEach(function (c) {
                        if (_app.filterCampeonato(c)) {
                            campeonatos.push(c);
                        }
                    });
                    return campeonatos;
                },
                getJogos: function (campeonato) {
                    var _app = this;
                    var jogos = [];
                    campeonato.jogos.forEach(function (jogo) {
                        if (_app.filterJogo(jogo)) {
                            jogos.push(jogo);
                        }
                    })
                    return jogos;
                },
                checkFiltros: function () {
                    if (!this.findData) {
                        if (this.findPais == '*' && this.findCampeonato == '*') {
                            return false;
                        }
                    }
                    return true;
                },
                filterPais: function (pais) {
                    var _app = this;
                    if (this.findPais == '*' || this.findPais == pais.id) {
                        if (this.getCampeonatos(pais).length > 0) {
                            return true;
                        }
                    }
                    return false;
                },
                filterCampeonato: function (campeonato) {
                    var _app = this;
                    if (_app.findCampeonato == '*' || _app.findCampeonato == campeonato.id) {
                        if (_app.getJogos(campeonato).length) {
                            return true;
                        }
                    }
                    return false;
                },
                filterJogo: function (jogo) {
                    if ((new Date()).getTime() < (new Date(jogo.dateTime)).getTime())
                        if (!this.findData || jogo.data == this.findData) {
                            return true;
                        }
                    return false;
                },
                setPais: function (pais) {
                    if (pais) {
                        this.findPais = pais.id;
                        this.findCampeonato = '*';
                    } else {
                        this.findPais = '*';
                    }
                    this.findData = null;
                },
                setCampeonato: function (campeonato) {
                    if (campeonato) {
                        this.findCampeonato = campeonato.id;
                        if (this.findPais != '*' && this.findPais != campeonato.pais) {
                            this.findPais = '*';
                        }
                    } else {
                        this.findCampeonato = '*';
                    }
                    this.findData = null;
                },
                setData: function (data) {
                    this.findCampeonato = '*';
                    this.findPais = '*';
                    this.findData = data;
                },
                maisCotacoes: function (jogo) {
                    this.mJogo.jogo = jogo;
                    this.mJogo.tempo = 90;
                    \$('#modal-cotacoes').modal(\"show\");
                },
                apostar: function (jogo, tempo, cotacao) {

                    var _app = this;

                    this.aposta.jogos
                        .forEach(function (v, i) {
                            if (v.jogo.id == jogo.id || !_app.filterJogo(v.jogo)) {
                                _app.aposta.jogos.splice(i, 1);
                            }
                        });

                    jogo.apostaEm = tempo + cotacao.campo;

                    if (cotacao.principal == '1' && tempo == '90') {
                        jogo.outras = false;
                    } else {
                        jogo.outras = true;
                    }

                    this.aposta.jogos
                        .push({
                            jogo: jogo,
                            tempo: tempo,
                            cotacao: cotacao,
                        });

                    \$('#modal-cotacoes').modal(\"hide\");

                },
                inArray: function (needle, haystack) {
                    var length = haystack.length;
                    for (var i = 0; i < length; i++) {
                        if (haystack[i] == needle) {
                            return i;
                        }
                    }
                    return -1;
                },
                rmAposta: function (index) {

                    var aposta = this.aposta.jogos[index];

                    if (aposta) {
                        aposta.jogo.apostaEm = null;
                        aposta.jogo.outras = false;
                        this.valorAposta = this.apostaMinima;
                        this.aposta.jogos.splice(index, 1);
                    }
                },
                limpaAposta: function () {
                    this.aposta.jogos.forEach(function (j) {
                        j.jogo.apostaEm = null;
                        j.jogo.outras = false;
                    });
                    this.aposta.jogos = [];
                },
                finalizarAposta: function () {

                    var _app = this;

                    var aposta = {
                        valor: this.valorAposta,
                        cliente: this.cliente,
                        jogos: [],
                    };

                    ";
        // line 589
        if ( !($context["user"] ?? null)) {
            // line 590
            echo "
                    ";
        }
        // line 592
        echo "
                    this.aposta.jogos.forEach(function (v, index) {

                        var jogo = v.jogo;

                        aposta.jogos.push({
                            jogo: v.jogo.id,
                            tempo: v.tempo,
                            cotacao: v.cotacao.campo,
                        });

                    });

                    \$('html').addClass('loading');

                    axios
                        .post('apostar/apostar', aposta)
                        .then(function (response) {

                            var e = response.data;

                            if (e.result == 1) {
                                _app.aposta.jogos = [];
                                _app.valorAposta = 1;
                                window.localStorage.removeItem('apostaJogos');

                                if (e.codigo) {

                                    swal({
                                        title: \$.trim(e.codigo.replace(/(.{3})/g, '\$1 ')),
                                        text: 'Bilhete gerado com sucesso!\\nProcure um dos nossos cambistas para validar o seu bilhete.',
                                        icon: 'success',
                                        button: {
                                            text: 'Imprimir',
                                            closeModal: true,
                                            value: {link: e.link},
                                        }
                                    })
                                        .then(function (e) {
                                            popUp(e.link, '_blank', {
                                                width: 320,
                                                height: 380,
                                            });
                                        });

                                } else {

                                    swal('Sucesso', 'Aposta realizada com sucesso!', 'success');

                                }

                            } else {
                                swal('Aviso!', e.message, 'warning');
                            }
                        })
                        .catch(function () {

                        })
                        .then(function () {
                            \$('html').removeClass('loading');
                        });

                }
            }
        });

    </script>

";
    }

    public function getTemplateName()
    {
        return "website/page/aposta.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  712 => 592,  708 => 590,  706 => 589,  486 => 372,  482 => 371,  478 => 370,  474 => 369,  470 => 368,  466 => 367,  446 => 350,  408 => 314,  404 => 312,  400 => 310,  398 => 309,  395 => 308,  392 => 307,  379 => 297,  375 => 296,  369 => 293,  366 => 292,  354 => 282,  352 => 281,  347 => 278,  345 => 277,  319 => 254,  315 => 253,  311 => 252,  304 => 248,  300 => 247,  296 => 246,  281 => 234,  273 => 228,  270 => 227,  155 => 114,  152 => 113,  131 => 95,  38 => 4,  35 => 3,  15 => 1,);
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "website/page/aposta.twig", "/home2/bets01/public_html/app/views/website/page/aposta.twig");
    }
}
