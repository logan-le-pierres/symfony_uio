/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  3                                          /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

1/ symfony new project_name --version=num_version
2/ code project_name pour ouvrir dans vsCode le dossier 
3/ Les seuls élements qui nous interessent sont : "src" et "config" // 
4/ Public est le dossier au public, cad le point d'entrée, c'est le front controller (index.php)
5/ "php bin/console" permet d'avoir une liste de commande que l'on peut taper et important de regarde ce qu'il s'y trouve

6/ php -S localhost:8000 -t public  (===> IMPORTANT de rajouter -t public pour le lancer a partir de ce fichier)
        ---> CTRL + C pour stoper le serveur

Il faut retenir ici que ce serveur local php est bien, mais celui de symfony est mieux, notamment quant à Enabling TLS qui permet de passer toujours en HTTPS (sécurisé) 
Par exemple il suffit de lancer symfony server:ca:install pour installer sur l'ordinateur en local une autorité de certification.
7/ Une fois lancé par ce biais on peut simplement utiliser "symfony serve" et il sera en https. Toutefois pour garder la main sur le terminal il est interessant de le lancer avec "-d"
    Cela signifie qu'il va le lancer en demo et nous gardons la main sur le terminal.
8/ Pour arreter le serveur la commande est "symfony server:stop"


/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  4                                          /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

1/ Route.yaml est un fichier qui permet de définir les routes : le premier élement est l'identifiant , vient ensuite une URL (path) et un controller (fonction qui va traiter cette URL) 
2/ Voir le fichier que l'on a nommé TestController qui nous a permis de vérifier si la route créée fonctionne bien.
3/  L'objet Request (voir avec un dump) possedes les propriétés $_"QQCH"(request pour POST, query pour GET, server pour SERVER, fils pour files et coockies pour cookies).
4/ Comment notre controller va pouvoir nous renvoyer une réponse ? Toutes les fonction qui prennent en charge des requetes doivent TOUJOURS TOUJOURS retourner une instence de la classe response qui vient du package HTTPFundation
5/ 
MAJ ===> Plutot que de mettre notre "$request = Request:: createFromGlobals();", on va désormais l'injecter en parametre de la fonction elle même (ici test en l'occurence) ==> Request $request

6/ Pour le chapitre en 4.1 il s'agit de comprendre que le query de notre requete peut etre remplacé par un des element qui figure dans le dump de l'objet Request(attributes,request,query,server,files etc)
    Du coup en remplaçant 'query' par 'attribute' on reussi a récupérer la valeur passé dans l'url
    A préciser que nous avons également ajouté "/{age}" à la suite de "path: "/test/" 
    Le probleme c'est qu'en ne mettant aucune valeur apres test il renvoit une erreur. Pour parer à ca il suffit de lui indiquer(fichier route) une valeur par defaut pour age.
    Aussi pour ne pas permettre de mettre autre chose qu'un integer il suffit de rajouter l'option "requirements" avec "age: \d+".
MA-GNI-FIQUE mais on peut faire plus court en integrant ces "defaults" et "requirements" directement dans le {age} ==> {age<\d+>?0}
Une derniere chose la dessus : on peut même virer "$age = $request->attributes->get("age", 0);" et mettre simplement en dernier parametre de la fonction $age

7/ On voit par la suite d'auter type d'options : methods(permet de définir quels types de méthods sont attendues(get, post etc)) // host(permet d'acceder a notre site que selon un certains typage)
Derniere chose pour vérifier http ou https on peut le param avec les schemes.

8/ Depuis le debut on a créé des configurations de routes dans le fichier route mais il est possible de le faire en créant des fichiers dans le dossier route pour mieux structurer ses chemin
Mais ce n'est pas tout puisque on peut l'intégrer directement en parametre :
    /*
    *@Route()
    */
    On clique droit sur route et on importe cette classe puis on clique sur annotation route.
    On place en parametre de Route() 1/ le chemi 2/ le nom 3/pas besoin de mettre le controller puisque on est deja au dessus de la fonction à appeller
    Là il y aura une erreur donc il faut installer des packages supplementaire (symfony flex) => C'est un plugin de composer et avec "composer require annotations" il nous install le package permettant de lire les annotations 
    IMPORTANT d'aller jetter un oeil sur packagiste.org 

/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  5                                          /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

Container de service 

1/ Un service est un outils, une classe.
    En tapant "php bin/console debug:autowiring" 
Autowiring => symfony analyse le constructeur d'une classe afin de lui fournir ce qu'elle demande (quels service y mettre)
    Il en existe de plusieurs type : loggers, mailer, router...
    On les obtient soit par injection de dépendance directement dans les parametre du __constructeur soit MAIS ATTENTION au niveau des fonction (méthodes) couplée a une route et uniquement dans le controller.

2/ Comment créer ses propres services ? Dossier "src" (cf Taxes) et il faut savoir que toutes les classes déclarées dans "src" ce sont des service que l'on peut demandé a symfony
3/ Pour bien comprendre les service il est impératif de bien saisir la notion de "container de services" 
    ==> Dans symfony on utilise une librairie qui s'appelle symfony/dependency-injection // les bundles symfony mettent deja à disposition des services prédef, mais on a egalement vu qu'il est possible d'en creer nous meme dans/src.
4/ On s'aperçoit qu'en mettant en paramètre du construct dans la classe calculator "float $tva" il y a un message d'erreur. Pour gérer ça on va pouvoir apprendre au container ce qu'on veut dire par la, comment il doit le construire 
    => Dans le dossier config, fichier "services.yaml" ==> tout en bas, en faisant attention a l'indentation on met 
    App\Taxes\Calculator: 
        arguments:
            $tva: 20
ET PAF ça remarque (on vient de lui expliquer à quoi correspond $tva) !

Comment définir dans le container de service définir des librairie externes qu'on va télécharger ?
(def SLUG = phrase ecrite au format URL ) On vient d'installer cela via packagiste puis nous avons :
   => "use Cocur\Slugify\Slugify;"
   => Instancier la classe Slugify et testé, cela marche
Pour le coup là ça peut aller mais si jamais on doit créer plusieurs fois la même classe etc ça peut devenir vite relou, donc autant la passer en parametre du constructeur, cependant on doit expliquer au service.yaml ce qu'il en est. 
            => on lui passe le chemin et apres les : on met un ~ (tild) si on a rien de spécifique à lui dire. 

5/ La différence entre un bundle Symfony et une librairie classique(comme par ex slugify que nous venons d'installer)
  LA grosse diff c'est que la librairie de service suppose qu'on aille manuellement expliquer dans le service.yaml ce qu'il en est alors que bundle va de lui même "expliquer" ce qu'il en est sans qu'on n'ai rien a toucher.
Prennons un exemple : composer require twig (rappellons d'ailleurs ici que "twig" en soit n'existe pas mais avec symfony flex il comprend directement ce qu'on veut)
    Cela est ajouté a bundle.php et devient connu de noter projet? Sachons qu'à l'origine il y en existe de prédef dans le kern 

6/ (5.9) Pour bien comprendre la spécificité d'une fonction d'un controller qui est lié a une route ! 
Quand symfony reçoit une requete http il va vérifier avec l'UrlMatcher si la route correspond a qqch. Ensuite il va voir qu'elle fonction doit répondre a cette route.
Puis viens une fonction qui s'appelle l'ArgumentResolver 
        --> 3 possibilitées : 
        1/ Un des paramètre est "Request" => Il va aller chercher ça
        2/ Le parametre n'a pas de type, simplement une chaine de caractere par exemple ET qui est un parametre de la Route, pas de soucis il va aller chercher ce qu'il y a dans l'url a la place de prenom(par ex)
        3/ L'argumentResolver se rend compte que ce qui est appellé sont des services qui sont dans le container.
En soit l'ArgumentResolver est le "petit robot" qui va analyser la méthode liée à la Route afin de découvrir ses paramètres et de les lui fournir !
EXERCICE 
-> Service Detector (a faire dans classe detector dans le dossier des taxe avec methode public hellocontroller)


/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  6                                          /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

1/          D E C O U V E R T E   D E   T W I G \o/ 
 Pour bien démarrer cette session, notons que tout ou presque a été mis en commentaire.
 De là, on appelle dans notre fonction hello "Environment $twig", puis on creer un fichier dans template=>"hello.html.twig"
 Ensuite dans notre fonction hello on vient mettre $html = $twig->render('hello.html.twig)
 RENDER() permet d'aller lire un fichier twig et nous rendre du html (inutile de dire que cela se situe dans le dossier template il le devine solo)
 3 syntaxes sont utilisables dans twig : 
                1/ La syntaxe qu'on pourrait appeller AFFICHE :{{variable OU fonction(); OU ternaire par ex}}
                2/ La synthaxe action : {%if age<18%}, else etc etc, destinnée a amener du dynamisme
                3/ {#commentaire#} permet de commenter

2/ Si on appelle {{name}} dans le fichier twig il nous indique une erreur : il faut lui passer en parametre de render avec un tableau associatif.
    => De la ligne 10 a 29 sur le fichier hello.html.twig nous voyons differentes possibilités de Tags
 3/ Pour la 6.6 nous allons voir comment naviguer dans un tableau associatif

    6.7/ Quand on regarde dans le seul fichier existant (base.html.twig) on rencontre des balise avec "block"
    En fait on peut dans le fichier hello2.html.twig aller extends le ficher base, et target son block body pour y inser le h1 (ou autre)
    6.8/ La notion d'inclusion 
    Imaginons qu'on veuille reutiliser à plusieurs endroit certains bouts de code : autant créer un fichier twig à part (appellé un "partial");
    On créer _formateur.html.twig et on lui passe "<p><strong>{{formateur.prenom}}</strong> {{formateur.nom}}</p>" puis dans notre fichier hello2 on lui indique 

    "{% include "_formateur.html.twig" with {"formateur":formateur1} %}
     {% include "_formateur.html.twig" with {"formateur":formateur2} %}"
     (Autrement dit on inclut le "_formateur" et on dit "tu va dans ce fichier recupérer formateur 1 pour formateur (tab associatif))

3/ Important : ici plutot que de répéter du code (hello et example) il est tout de même plus quali de se faire livrer des services dans le __construct (Environment $twig) pour pouvoir l'utiliser à l'infini par la suite et donc
de le supprimmer des hello/example. On pensera pour le coup à bien modifier en mettant le $this dans "return $this->render('hello2.html.twig',[
            'name' => $name]);" par exemple.

De là nous allons créer une public function render() qui prendra en paramètre =>  render(string $path, array $variable = []);
Ceci étant "neutre" elle permet d'etre appeller dans les functions où on a besoin de render() où on mettra en paramètre la page twig voulue ($path) et la variable voulue (ex: ['age'=>33]) !
    => Ainsi on optimise notre code en ayant besoin d'une seule ligne dans chaque function qui viendra appeller la function render à qui on a expliquer quels paramètres étaient attendue ! Propre.

4/ Quand on créer un controller on peut hériter de la classe AbstractController ce qui rend inutile la function render ligne 76, de même pour ce __constructeur.


/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  7                                         /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

===> Il est possible, dans le cadre de la gestion de BDD, d'utiliser PDO ou toute autre librairie.
Il existe par ailleurs un ensemble de librairie appellé DOCTRINE et qui représente un ORM (intégré dans symfony via bundle)
C'est une brique logiciel qui se place entre l'appli et la BDD et va faire lien en faisant correspondre les tables/enregistrements et le monde des objets.
==> CAD que chaque classe va représenter une table de la BDD
        DOCTRINE nous offre 3 outils : 
            1/ Entité(enregistrements)
            2/ Repository(depot/selection) permet de selectionner sur les tables
            3/ l'outils principal : le manager de doctrine, permet de manipuler les entité (CRUD) 

Faire attention pour nous car doctrine nous permet certes de ne plus s'occuper de la BDD à proprement parler DONC ne nous prépare pas aux attentes du titre !!!!
On va donc non pas utiliser SQL mais DQL : la difference est que nous n'allons pas effectuer des requetes sur nos tabkles mais sur nos classes.

Bien, pour commencer nous allons écrire "php bin/console doctrine:database:create",
Nous avons au préalable, dans le fichier .env, mis a jour la ligne SQL ( DATABASE_URL="mysql://root:@127.0.0.1:3306/uio?serverVersion=5.7"
Ensuite nous allons rentrer dans le terminal : composer require maker (pour rappel encore une fois maker en soit n'existe pas mais symfony flex nou le permet)
"php bin/console make:migration" va générer un fichier dans le dossier migration qui se nommera à la date et l'heure de la migration (permet de trier plus facilement du coup). Si on l'ouvre on découvre la requete SQL/DQL ainsi que deux fonctions :
==> La premiere permettant de passer de A -> B (ou autrement dit de l'état initial des données à celui après migration)
==> La deuxième permettant de passer de B -> A (fonction down() permettant de revenir en arriere si on a fait une erreur par exemple)

Il faut bien comprendre qu'à ce stade le fichier de migration est "sur la rampe de lancement", c'est à dire qu'il est pret a etre "injecter" dans la BDD mais ne l'est pas encore. Il suffit de regarder les informations dans le termnal pour le comprendre,
il nous propose de poursuivre avec la commande "php bin/console doctrine:migration:migrate";

Par la suite on alimente de vraies données la BDD via phpmyadmin,

1/ Allez voir les fichiers HomeController et Product.php
Differentes méthodes s'offrent à nous pour jouer avec la BDD et récupérer ce que l'on veut => 
    Avant ça rappellons ce que nous venons de faire : 
    1/ Appeller le service "ProductRepository $productRepository" dans notre fonction homepage du HomeController
    2/ Définir ce que nous voulons passer a $products (objet)
    3/ Quelques exemples count,find, findBy, findOneBy,findAll() etc (pour findBy on peut passer plusieurs criteres et paramètres)

Video 7.7, comment utiliser le manager d'entités :
=> Toujours pareil soit dans le __construct soit dans une méthode relié à une route, on passe en parametres "EntityManagerInterface $em"
    Puis on instancie un nouveal objet de la class Product dans laquelle on vient définir ses attributs "$product->setName('Table en métal');
        $product->setPrice(2500);
        $product->setSlug('Table-en-métal');"
        etc
De là on va utiliser les méthodes persist() et flush() qui respectivement vont permettre de persister/préparer et d'injecter en BDD.


    Comment faire pour modifier un produit ? =>
    On va utiliser le repository :
    |=>    "$productRepository = $em->getRepository(Product::class);"
    |
    |=> Signifie "Dans l'attribut "$productRepository" on récupère via l'EntityManager($em) à qui on demande un repository(getRepository()). 
        Etant donné qu'il y en a potentiellement plusieurs on vient lui spécifier lequel nous souhaitons récuperer celui qui a la gestion Product.
        Cela s'exprime par "(Product::class)".  
    A retenir pour l'entity manager : find,flush,remoove,persist

EXERCICE fait avec grand succès ! 
=> Toutefois imaginons qu'on se soit trompé lors des la création, comment faire pour changer tout ça ? C'est ce qu'on voit en 7.10

2/ Intéréssant de se pencher sur "php bin/console doctrine" et notamment celles sur migration
Avec : php bin/console doctrine:migration:status on peut voir les dernieres migrations
Avec : php bin/console doctrine:migration:migrate --help on peut voir pas mal de chose interessantes
On peut par exemple revenir à la version premiere, precedente, derniere etc etc 


Nous allons maintenant voir les fixtures ==> JEUX DE FAUSSES DONNEES 
    Il existe un bundle qui s'appelle Doctrine Fixtures Bundle

On tape donc "composer require orm-fixtures" (==> Même mayonnaise que vu avant : orm-fixture en soit n'existe pas mais symfony flex (alias) va nous permettre d'aller le chercher)
De la il nous créer un dossier dans src (DataFixture) qui va nous permettre de nous livrer  ObjectManager.
Allons dont voir le fichier AppFixtures.php et alnçons la commande "php bin/console doctrine:fixture:load"
Et là BOOM c'est insane mais on peut faire mieux ! Comme installer d'autres librairies nous permettant de rendre plus réaliste ce jeu de données. 
 _____________
|F   K   R <3 |
|__A___ E_____| 

Pour résumer : si on veut faire rejoindre un projet a quelqu'un on peut : 
1/ Il télécharge le projet
2/ Il met a jour son .env pour connecter à la base de données
3/ doctrine:database:create
4/ doctrine:migration:migrate et se retrouve avec les même tables que nous
5/ doctrine:fixture:load et il se retrouve avec un jeu de données insane
6/ On peut meme rendre ca plus réaliste avec faker


3/ Comment relier 2 tables entre elles ?
    => On imagine la table Catergory. On tape php bin/console make:entity et on luiajouter un attribut products avec un "s" 
        Quand le terminal nous demande quel type nous voulons, en tapant "?" une liste s'affiche et notamment celle concernant les associations
        On selectione (pour cet exemple) OneToMany

/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  8                                         /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

Une seule et unique vidéo sur le debug pack (profiler) qui permet d'avoir une interface sympa pour debuger.

/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  10                                         /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

Pour aller plus loing avec twig ! 


/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  10                                         /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

Les formulaires  

De même que pour la BDD où on peut utiliser <PDO, une librairie de notre choix etc mais qu'on a utilisé doctrine, et bien on peut egalement faire de même pour les formulaire mais là encore Symfony nous propose des choses bien grandes, voyons plutôt.
"composer require form" tu connais

10.4             I M P O R T A N T 

C'est pour configurer un form avec le formbuilder.
La fonction 'add' peut prendre 3 paramètres  
1/ Le nom du champs que l'on souhaite
2/ Le type de champs (symfony pour ça utilise des classes) ici on va donner a add le nom de la classe qui nous permettra de representer le type de ce champs (texte par ex) => TextType(de component pas de doctrine)
3/ Tableau d'options : selon le type défini) 

Voir la video 10.6 pour relier la bdd aux choix de la liste déroulante.
    En gros on s'est fait livrer le CategoryRepository pour pouvoir par la suite venir les stocker dans le tableau $options. Et lui même on a pu le remplir au bon endroit en le mettant en valeur de la clefs attendue par choices (de la class ChoiceType).

Il existe des solutions plus simple ! Par exemple le chmps EntityType : 
=> On cesse de se faire livrer CategoryRepository, puis on vire ChoiceType pour le remplacer par EntityType(en reliant ce ->add comme avant)
=> On ne va plus utiliser 'choices' ici(le reste on garde)
=> On le remplace par 'class' => Category::class et on suit de 'choice_label' => 'name'


10.8/ Dans twig, quand on fait appel a FormView, qui est issu de la fonction createView, cela nous creer un formulaire mais assez basique.
Pour rendre ca un peu plus flexible on peut utiliser "form_start(formView)"
    =>CF la doc sur les fonctions (a mettre dans twig) "form_start", "form_widget","form_end","form_errors"
Ce qu'il faut comprendre ici c'est qu'on décompose le simple FormView en plusieurs parties, ce qui nous permet d'inserer du contenu.
On peut même aller plus si admettons nous voulons à l'interieur du form_widget etre encore plus précis : 
==> form_row(formView.name)
Et on peut encore allez plus loing, etc etc 

Avec form_theme formView 'boostrap_4_layout.html.twig' on peut inserer un theme predef sans s'embeter a tout faire à la mano

10.11 = recapitulatif.

10.12/ Pour faire une action/récuperer les informations d'un formulaire : 
    1/ On se fait livrer "Request $request"
    2/ $form->handleRequest($request)
    3/ $data = $form->getData()

10.13 Pour stocker  => EntityManagerProduct 
10.14 Création d'une classe de formulaire 


10.15 On va php bin/console make:form ProductType qui va généré un fichier dans le src/Form.
On a une classe ProductType qui extends de AbstractType et qui contient plusieurs méthodes et notamment FormBuilderInterface,
qui a récup nos "add" de notre variable $builder, ENORME !
De même une fonction configurationOptions a recupéré notre " 'data_class' => Product::class";
On recupere tout ce qui concerne le formulaire pour le mettre dans controller (rien a faire la au final) et on l'inject dans notre ProductType.php
CTRL + ESPACE pour importer les bonnes classe : en gros quand on code directement il nous le propose mais quand on copie colle des chose il n'est pas censé aller créer le use etc du coup avec ce raccourci cela permet de le faire.


Du coup gros gros gain de place, et optimisation (pas de répétitions) ==> Anciennement nous avions les lignes suivantes dans notre HomeController :
        
        $builder =$factory->createBuilder(FormType::class, null, [
            'data_class' => Product::class
        ]);

        HORS ==========> maintenant quand on demande a notre factory de creer un builder, il n'est pas necessaire de passer par FormType mais bien plutot par ProductType

        $builder =$factory->createBuilder(ProductType::class); suffit désormais et pourra être rappellé par la suite.

10.16 Decouverte des raccourcies de l'AbstractController

 
10.17



On passe directos à la 14.1 il faudra revenir sur cet écart plus tard.

/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  14                                         /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

Deux questions différentes à aborder ::

        A U T H E T I F I Q U A T I O N                                           A U T O R I S A T I O N 

Es-tu vraiment celui que tu prétends être ?                             As tu le droit de faire ce que tu veux faire ? 


Composant security de symfony.

Les firewall = différentes regions/frontieres de notre site qui sont finalement les différentes URL.

Bien pour commencer nous avons besoin d'un user, donc lezgo "php bin/console make:user User
Cela genere plusieurs fichier comme par exemple User.php // UserEntity.php, ou encore l'ajout de données dans security.yaml
Dans ce dernier on trouve notamment : 
                    => clef "encoders" : permet d'expliquer à l'encodeur de symfony que quand on veut encoder un mdp de l'entité user on veut utiliser tel ou tel algorythme.(ici c'est sur auto par defaut)
                    => Providers indiquent au composant Security où se trouvent les données des utilisateurs
                    => Firewall 

L'entité User qui est apparue implemente la UserInterface : elle possede un id, une colonne email et ENFIN une colonne des roles qu'il a mis solo
et qui va nous permettre par la suite de gérer les autorisations (as tu le droit de faire ceci ou cela) ?
Puis vient une donnée password.
Viennent les Geters et les Seters : 
La methode GetRole qui récupere les roles et implemente de facto le ROLE_USER ==si il y a un user il y aura forcement un role user 

POUR PUSH LES DONNEES FAKE DANS LA BDD IL FAUT " php bin/console d:f:l --no-interaction"
-> On se rend compte que les password n'ont pas été encodés !

14.6 => encoder
14.7 => authentification 
    Symfony va pouvoir contenir plusieurs façons de s'authentifier. Des fois il faut, des fois non. Genre aller voir des produits et les ajouter au panier ne necessite pas de s'authentifier par contre l'espace de loggin et le fait de s'authentifier oui !
  
Nous avons fait un "php bin/console make:auth" afin de générer deux fichiers : "LoginFormAuthenticator" et une mise a jour du fichier security,
Puis nous avons fait un "php bin/console make:controller SecurityController" qui nous a créé : 
 - created: src/Controller/SecurityController.php
 - created: templates/security/index.html.twig 

 Le LoginFormAuthenticator doit etre vu comme un douanier qui va gérerer les authentifications 

 14.12 : les methodes Supports.
  Dans la fonction supports du fichier LoginFormAuthenticator si on dd("coucou") et bien a chaque fois qu'on appel une page et il nous sortira le dump.
  Or nous ce que nous voulons c'est simplement faire appel au "douanier" une fois puis c'est tout. 
  Ainsi si nous mettons =>   return $request->attributes->get('_route') === 'security_login'
                                && $request->isMethod('POST');
                        CELA SIGNIFIE : "Je n'interviens que si la request possede dans ses attributs quelque chose qui s'apelle '_route' et qui doit etre egal à 'security_login'
                        De plus uniquement si la 'request' est en méthod 'POST'
                        Une fois que la methode support renvoit "Vrai", toute la procédure va être enchenchée.

Ensuite, via le getCredential on va venir recuperer les infos qui se trouvent (bien revoir la partie sur httpFundation via "dd") dans 'login' via la methode 'get' (tableau composé de trois données
=> email, password et token). 
Ce qu'on retourne ici, donc les informations de connexion sous forme de tableau sont envoyées à la methode suivante getUser par l'intermédiaire de $credentials.
L'idée ensuite c'est de voir si grace aux infos recup arrive on a a retrouver dans la BDD un utilisateur. Notons qu'à côté de $credentials il y a "UserInterface" qui permet d'aller chercher un user dans la BDD en fct de son nom d'user.
Il n'y a qu'a aller voir dans le security.yaml pour constater que dans le firewall=>main => l'utilisateur qu'on utiliserait, le fournisseur de données (provider) serait app_user_provider. Et c'est quoi le app_user_provider ? 
Hein ? On remonte un peu et on voit clairement que c'est  le user ayant la propriété email.
Donc ce user provider est capable d'aller chercher un utilisateur dans les entité users.
De là, dans le getUser, il va vérifier si ce qu'il lui est renvoyé correspond a quelquechose dans la BDD
Dans checkCredential on va demander au "douanier" de vérifier que le MDP fourni correspond bien au mdp de la BDD.
Le problème, vous l'aurez vu c'est que le mdp dans la BDD est encoder, cependant grâce au 
LoginFormAuthenticator est une class comme une autre dans mon dossier src qui est géré par mon container de service on peut donc se faire livrer des outils 
=> UserPasswordEncoderInterface 

14.14 LES ECHECS POSSIBLES LORS DE L'authentification

On peut se demander pourquoi, à partir du moment où on en est là, on a toujours pas écrit la moindre chose concernant "et si l'user n'est pas trouvé je fais quoi ?" ou "et si le password n'est pas bon je fais quoi".
En fait inutile de coder quoi que ce soit à ce niveau là puisque si on regarde les functions getUser, loadUserByUsername ou encore checkCredentials, elles héritent toutes
de AuthenticationException donc si jamais ca retourne FALSE, paf, ça renvoit a onAuthenticationFailure !
  => Pour voir ça d'un peu plus près on "dd("failure", $exception);" et on se rend compte que 
  ==>  #message: "Authentication failed because "App\Security\LoginFormAuthenticator::checkCredentials()" did not return true."<==
  Donc que l'erreur vient du mdp(chechcredantials) // De même si on se trompe dans l'email il nous indique que ca vient de là ("User "user0zz@gmail.com" not found.")

  14.15 Que faire en cas de succès et de failure ? 
        =====> Tout d'abord qu'on soit sur du succes ou failure, si on ne demande rien en return, alors la requete continuera son chemin.
                Nous, nous sommes sur une requete en POST vers sécurity controller en security_login donc : 
        => Pour une failure il suffit de ne rien mettre et la fonction tournera en boucle et se redirigeant vers la page de connexion.        
        => Pour succès il suffit de redirigé vers une page (celle de l'accueil pour notre cas)
SU PER BE !! 
M'enfin il serait interessant de pouvoir afficher un message d'erreur pour en informer l'utilisateur.
14.16
^
En fouinant un peu avec php bin/console debug:autowiring auth, on se rend compte qu'il existe un service "AuthenticationUtils" qui permet d'extraire l'erreur de sécurity.
 Ainsi quand on l'appelle dans le login() il nous montre deux methodes possibles : getLastAuthenticationError et getLastUsername.
 Dumpons les pour voir !

 AIE AIE AIE il renvoit null pour la premiere(bizarre et en plus on reste sur la page login) et l'username pour la deuxième(normal).
 Pourquoi ? Si on va voir dans le contenu de "AuthenticationUtils" on s'aperçoit qu'il est censé nous retourner qqch trouvé dans la session ou la requete, or on a jamais touché à ça.
 Ce qui veut dire que c'est a nous de stocker l'erreur qu'il y a eu => dans onAuthenticationFailure on met = > 
        $request->attributes->set(Security::AUTHENTICATION_ERROR, $exception)


14.17 va nous permettre de voir comment on peut prendre la main sur ces messages d'erreur :

    Avec try et catch and throw ! cf LoginFormAurthentication ! En gros il s'agit d'intercepter le message d'erreur pour lui donner une autre directive !
Enfin pour garder en mémoire dans l'input l'adresse mail on va dans notre controller security et on =>             $form = $this->createForm(LoginType::class, ['email' => $utils->getLastUsername()]);

14.19 on va faire la gueule : l'Authenticator form_login deja livré !!

Allez voir le security.yaml en cas de probleme (username_parameter)

14.20 LA DECONNEXION

Dans le security.yaml, on marque logout:
                                    path: security_logout

Puis dans le controller on creer une public function vide avec la route pour cabler security_logout.
Prochaine etape : Mettre en place les bouton login et logout.
Il faut savoir qu'en chaque fichier twig il subsite une variable globale nommé APP (dispo dans touuuuus les fichiers twig)
==> Elle possède en elle même des infos sur l'utilisateur connecté, la session, la request.


TIPS ASTUCE AND CO ==> Avec la commande php bin/console debug:config +"quelquechose" on nous donne un visuel de toute ce qui est possible de paramétré.Le gros avantage réside dans le fait que l'on voit également ce qui est aramétré par defaut !
    Autre commande ==> "php bin/console config:dump" qui nous permet de connaitre toutes les otpions possibles 


/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  15                                         /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/

LES AUTORISATIONS 

Quand on souhaite supprimer l'acces de tout ou partie de notre application, cela se passe dans le security.yaml ==> tout en bas au niveau des access_control.
Par exemple, en décommentant la ligne admin. Il nous renvoit une erreur : "The "App\Security\LoginFormAuthenticator::start()" method must return a Response object ("null" returned)."
Pour cela il faut aller paramétrer la methode start()>LoginFormAnthenticator. 
Cette methode doit retourner une réponse qui va expliquer a l'utilisateur comment il doit s'authentifier.
On y insert donc la ligne : "return new RedirectResponse('/login');" Et hop c'est bon, on peut tester en se connectant en admin ou non et en etant deco.
 => L'idée à retenir ici c'est que la méthode start permet dans un authenticator, pour un utilisateur non connecté essaye d'acecder à une ressource pour se connecter alors la 
 methode start sera apellée et le redirigera où il faut (à nous de le définir).

15.3/ revoir
 Cette méthode est un peu bourrin, mais il y a plus spécifique pour rentrer dans des politiques détaillées.
 Par exemple si tu veux pouvoir donner la vue aux utilisateurs sans pour autant qu'il puisse éditer. Il faudrait récupérer en BDD les infos d'un utilisateur en question et vérifier si il a le role admin.
 Avec notre fameux php bin/console debug:autowiring security on peut voir qu'il y a qqch avec "security"
        => Du coup on se fait livrer "Security" (en vérifiant bien que le "use" se met a jour) puis dans la fonction edit 
        "$user = $security->getUser();
        if (!in_array("ROLE_ADMIN", $user->getRole)) == est-ce qu'on trouve role admin dans le tab que va nous renvoyer l'utilisateur quand on va lui demander de choper ses roles.
        En gros on lui demande "s'il n'y a pas role_admin ALORS "throw new AccessDiniedHttpExeption("Vous n'avez pas accès à cette ressource");
        En prennant un id dans la BDD 

15.4/ Permet de reduir ce qu'on a fait en 15.3 => Toujours en s'étant fait livrer Security on peut "$this->denyAccessUnlessGranted("ROLE_ADMIN",null,"Vous n'avez pas le droit d'acceder à cette ressources"
Et cela raccourci drastiquement ce qu'on a pu faire avant.

15.3 Encore trop long ? On peut encore réduire en important la class "@IsGranted("ROLE_ADMIN",message="Vous n'avez pas le droit d'acceder à cette ressources");
On la place au dessus de la méthode en question mais on peut très bien la mettre au dessus du nom de class pour qu'elle s'paplique partout

15.6/ On va ici voir comment faire en sorte qu'un élement ne soit modifiable que par la personne qui l'a crée. La question n'est donc plus de savoir si nous sommes admin ou pas, non, la question ici est de savoir si nous sommes celui ou celle qui a crée.
==> php bon/console make:entity Category ==> On répond "owner" à la seconde question (qui signifie proprio) puis "relation", on a relie (ici en tout cas) avec la class user. 
Puis ManyToOne.
On relie les id_owner créer dans la tablea Category avec de vrai ID.

Bien, là l'idée va etre de récuperé l'identité de la personne 
    1/ Récuperer l'utilisateur
    2/ Elle n'est pas connecté alors on lui demande de se connecter
    3/ Vérifier si c'est le créateur de la catégorie 
    ==>     $user = $this->getUser(); (qui veut dire mais en raccourci : security->getUser())
            if(:$user) {
                return $$this->redirectionToRoute("security_login);
            }
            if($user !== $category->getOwner()){
                throw nex AccesdenyHttpException("Vous n'êtes pas le proprietaire de cette catégorie ")
            }

15.7/ LES VOTERS permettent d'encapsuler et de centraliser une logique d'accès dans une classe:

"php bin/console make:voter"

15.8/ On le repeterea jamais assez mais AUTHENTIFICATION = ROLE et AUTORISATION = DROIT !!!!
15.10 Recapitulatif
    Pour rappel en ce qui concerne les autorisations il y a trois techniques : 
    1/ Access control (YAML) : rôles et URL (technique bourrin)
    2/ Les controllers : Actions de controllers
    3/ Voters : droits sur des objets précis



/---------------------------------------------------------------------------------------------------/
/                                                                                                   /
/                                       C H A P I T R E  16                                         /
/                                                                                                   /
/---------------------------------------------------------------------------------------------------/


LES SESSIONS : 









+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

https://www.youtube.com/watch?v=3B3mnZBDuvU    18.34 