terraform {
  required_providers {
    azurerm = {
      source  = "hashicorp/azurerm"
      version = "~> 4.0"
    }
  }
}

provider "azurerm" {
  features {}
}

resource "azurerm_resource_group" "app" {
  name     = "edot-shop-inventory-rg"
  location = "Southeast Asia"
}

resource "azurerm_mssql_server" "inventory" {
  name                         = "edot-shop-inventory-sql-server"
  resource_group_name          = azurerm_resource_group.app.name
  location                     = azurerm_resource_group.app.location
  version                      = "12.0"

  administrator_login          = var.sql_admin_username
  administrator_login_password = var.sql_admin_password
}

resource "azurerm_mssql_database" "inventory" {
  name      = "edot-shop-inventory-db"
  server_id = azurerm_mssql_server.inventory.id
  sku_name  = "Basic"
}
resource "azurerm_service_plan" "inventory" {
  name                = "edot-shop-inventory-plan"
  resource_group_name = azurerm_resource_group.app.name
  location            = azurerm_resource_group.app.location

  os_type  = "Linux"
  sku_name = "B1"
}
resource "azurerm_linux_web_app" "inventory" {
  name                = "edot-shop-inventory-app"
  resource_group_name = azurerm_resource_group.app.name
  location            = azurerm_resource_group.app.location
  service_plan_id     = azurerm_service_plan.inventory.id

  site_config {
    application_stack {
      php_version = "8.3"
    }

    app_command_line = "cp /home/site/wwwroot/default /etc/nginx/sites-available/default && service nginx reload"
  }
}
