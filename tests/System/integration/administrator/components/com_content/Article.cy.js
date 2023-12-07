describe('Test in backend that the article form', () => {
  beforeEach(() => { cy.db_createUser({
    name: 'admin012',
    username: 'admin',
    email: 'test@example.com',
    password: 'admin12345678',
    }).then(() => {
      cy.doAdministratorLogin();
    });
  });
  afterEach(() => cy.task('queryDB', "DELETE FROM #__content WHERE title = 'Test article'"));
  // afterEach(() => cy.task('queryDB', "DELETE FROM #__users WHERE username = 'admin'"));

  it('can create an article', () => {
    cy.visit('/administrator/index.php?option=com_content&task=article.add');

    cy.get('#jform_title').clear().type('Test article');
    cy.clickToolbarButton('Save & Close');

    cy.get('#system-message-container').contains('Article saved.').should('exist');
    cy.contains('Test article');
  });
  
  it('can toggle featured status on article', () => {
    cy.db_createArticle({ title: 'Test article' }).then((article) => {
      cy.visit(`/administrator/index.php?option=com_content&task=article.edit&id=${article.id}`);

      cy.get('#jform_featured1').click();
      cy.clickToolbarButton('Save & Close');

      cy.get('#system-message-container').contains('Article saved.').should('exist');
      cy.contains('Test article');
    });
  });

  it('can archive an article', () => {
    cy.db_createArticle({ title: 'Test article' }).then(() => {
      cy.visit('/administrator/index.php?option=com_content&filter=');

      cy.searchForItem('Test article');
      cy.checkAllResults();
      cy.clickToolbarButton('Action');
      cy.contains('Archive').click();

      cy.get('#system-message-container').contains('Article archived.').should('exist');
    });
  });

  it('can delete an article', () => {
    cy.db_createArticle({ title: 'Test article', state: -2 }).then(() => {
      cy.visit('/administrator/index.php?option=com_content&filter=');
      cy.setFilter('published', 'Trashed');
      cy.searchForItem('Test article');
      cy.checkAllResults();
      cy.clickToolbarButton('empty trash');
      cy.get('.button-primary').click();

      cy.get('#system-message-container').contains('Article deleted.').should('exist');
    });
  });
});
