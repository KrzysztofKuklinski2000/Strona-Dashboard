<?php 

namespace App\Controller\Dashboard;

use App\View;
use LogicException;
use App\Core\Request;
use EasyCSRF\EasyCSRF;
use App\Traits\GetDataMethods;
use App\Middleware\CsrfMiddleware;
use App\Exception\NotFoundException;
use App\Controller\AbstractController;
use App\Service\Dashboard\SharedGetDataServiceInterface;

abstract class AbstractDashboardController extends AbstractController {

  use GetDataMethods;

  public function __construct(
    Request $request, 
    EasyCSRF $easyCSRF, 
    protected SharedGetDataServiceInterface $dataService,
    View $view,
    protected CsrfMiddleware $csrfMiddleware
    ) {

    parent::__construct($request, $easyCSRF, $view);
    
  }

  public function storeAction(): void {
    if (!$this->request->isPost()) {
      $this->redirect('/?dashboard=' . $this->getModuleName());
      return;
    }

    $this->csrfMiddleware->verify();
    $data = $this->getDataToCreate();

    if (!$this->request->getErrors()) {
      $this->handleCreate($data);
      $this->setFlash("success", "Udało się utworzyć nowy wpis");
      $this->redirect("/?dashboard=".$this->getModuleName());
      return;
    }

    $this->setFlash("errors", $this->request->getErrors());
    $this->redirect('/?dashboard='.$this->getModuleName().'&action=create');
    return;
  }

  public function updateAction(): void {
    if (!$this->request->isPost()) {
      $this->redirect('/dashboard/' . $this->getModuleName());
      return;
    }

    $this->csrfMiddleware->verify();
    $data = $this->getDataToUpdate();

    if (!$this->request->getErrors()) {
      $this->handleUpdate($data);
      $this->setFlash("success", "Udało się edytować");
      $this->redirect('/dashboard/' . $this->getModuleName());
      return;
    }

    $this->setFlash("errors", $this->request->getErrors());
    $redirectUrl = '/dashboard/' . $this->getModuleName() . '/edit';

    if (isset($data['id']) && $data['id'] !== '') {
      $redirectUrl .= '/' . $data['id'];
    }

    $this->redirect($redirectUrl);
    return;
  }

  public function deleteAction(): void {
    if (!$this->request->isPost()) {
      $this->redirect('/?dashboard=' . $this->getModuleName());
      return;
    }

      $this->csrfMiddleware->verify();
      $id = (int) $this->request->getFormParam('postId');
      $this->handleDelete($id);
      $this->setFlash('success', 'Udało się usunąć');
      $this->redirect('/?dashboard=' . $this->getModuleName());
      return;
  }

  public function publishedAction(): void {
    if (!$this->request->isPost()) {
      $this->redirect('/?dashboard=' . $this->getModuleName());
      return;
    }

    $this->csrfMiddleware->verify();
    $data = $this->getDataToPublished();
    $this->handlePublish($data);

    $this->setFlash('info', 'Udało się zmienić status');
    $this->redirect('/?dashboard=' . $this->getModuleName());
    return;
  }

  public function moveAction(): void {
    if($this->request->isPost()) {
      $this->csrfMiddleware->verify();
      $data = $this->getDataToChangePostPosition();
      $this->handleMove($data);
      $this->redirect("/?dashboard=". $this->getModuleName());
      return;
    }
  }

  /** Zwraca nazwę modułu, np. 'news', 'gallery' */
  abstract protected function getModuleName(): string;

  protected function getTableName(): string {
    return $this->getModuleName();
  }

  /**
   * Obsługuje logikę tworzenia posta.
   * @codeCoverageIgnore
   */
  protected function handleCreate(array $data): void {
    throw new LogicException(sprintf('The "%s" module does not support creating', $this->getModuleName()));
  }

  /**
   * Obsługuje logikę aktualizacji posta.
   * @codeCoverageIgnore
   */
  protected function handleUpdate(array $data): void {
    throw new LogicException(sprintf('The "%s" module does not support updating', $this->getModuleName()));
  }

  /**
   * Obsługuje logikę usunięcia posta.
   * @codeCoverageIgnore
   */
  protected function handleDelete(int $id): void {
    throw new LogicException(sprintf('The "%s" module does not support deleting', $this->getModuleName()));
  }

  /**
   * Obsługuje logikę publikowania posta.
   * @codeCoverageIgnore
   */
  protected function handlePublish(array $data): void {
    throw new LogicException(sprintf('The "%s" module does not support publishing', $this->getModuleName()));
  }

  /**
   * Obsługuje logikę przesówania posta.
   * @codeCoverageIgnore
   */
  protected function handleMove(array $data): void {
    throw new LogicException(sprintf('The "%s" module does not support moving', $this->getModuleName()));
  }

  /**
   * Obsługuje pobierania danych do tworzenia posta.
   * @codeCoverageIgnore
   */
  protected function getDataToCreate(): array {
    throw new \LogicException(sprintf(
      'The "%s" controller must implement the "getDataForCreate" method to use the "store" action.',
      $this->getModuleName()
    ));
  }

  /**
   * Obsługuje pobierania danych do aktualizacji posta.
   * @codeCoverageIgnore
   */
  protected function getDataToUpdate(): array {
    throw new \LogicException(sprintf(
      'The "%s" controller must implement the "getDataForUpdate" method to use the "update" action.',
      $this->getModuleName()
    ));
  }

  protected function renderPage(array $params): void {
    $params['flash'] = $this->getFlash();
    $params['csrf_token'] = $this->csrfMiddleware->generateToken();
    $this->view->renderDashboardView($params);
  }

  protected function getSingleData(): array {
    $postId = $this->request->getRouteParam('id');
    if ($postId === null || !ctype_digit((string) $postId)) {
      throw new NotFoundException("Required 'id' parameter is missing or invalid");
    }

    $postId = (int) $postId;
    return $this->dataService->getPost($postId, $this->getTableName());
  }
}
