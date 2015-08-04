<?php

namespace app\controllers;

use Yii;
use app\models\Book;
use app\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;
use yii\filters\AccessControl;

/**
 * BookController implements the CRUD actions for Book model.
 */
class BookController extends Controller
{
    // public function __construct()
    // {
    //    $this->layout = 'container';
    //    parent::__construct();
    //    // parent::__construct($this->id, $this->module);
    // }

    /**
     * Behaviors, eg. access control
     * @return array
     */
    public function behaviors()
    {
       $this->layout = 'container';

        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
            'access' => [
            'class' => AccessControl::className(),
            'only' => ['create', 'update', 'delete'],
            'rules' => [
                // deny all POST requests
                [
                    'allow' => false,
                    'verbs' => ['POST']
                ],
                // allow authenticated users
                [
                    'allow' => true,
                    'roles' => ['@'],
                ],
                // everything else is denied
            ],
        ],
            // 'access' => [
            //     'class' => AccessControl::className(),
            //     'rules' => [
            //         [
            //             'actions'       => ['index', 'view-config'],
            //             'allow'         => true,
            //             'roles'         => ['@'],
            //             'matchCallback' => function ($rule, $action) {
            //                 return in_array(
            //                     \Yii::$app->user->identity->username,
            //                     \Yii::$app->getModule('user')->admins
            //                 );
            //             }
            //         ],
            //     ]
            // ]
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return Yii::$app->request->isAjax ? 
            $this->renderAjax('view', [
                'model' => $this->findModel($id),
            ]):
            $this->render('view', [
                'model' => $this->findModel($id),
            ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post('Book');
            $model->name = $post['name'];
            $model->author_id = $post['author_id'];
            $model->status = $post['status'];
            $model->created_at = $post['created_at'];
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

                if ($model->upload()) {
                    $model->preview = 'uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                    $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }
        // if ($model->load(Yii::$app->request->post()) && $model->upload(UploadedFile::getInstance($model, 'imageFile')) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post('Book');
            $model->name = $post['name'];
            $model->author_id = $post['author_id'];
            $model->status = $post['status'];
            $model->created_at = $post['created_at'];
            $model->imageFile = UploadedFile::getInstance($model, 'imageFile');

            if ($model->validate()){
                    if ($model->imageFile && $model->upload()) {
                        $model->preview = 'uploads/' . $model->imageFile->baseName . '.' . $model->imageFile->extension;
                        $model->save();
                    }else{
                        $model->save();
                    }
                    if(\Yii::$app->session->get('referrer')){
                        return $this->redirect(\Yii::$app->session->get('referrer'));
                    }else{
                        return $this->render(['view', 'id' => $model->id]);
                    }
            }
        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
            // return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
