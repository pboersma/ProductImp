/* eslint-disable camelcase */

interface DataSourceCredentials {
  username: string | null,
  password: string | null
}

interface DataSource {
  datasource_name?: string | null,
  datasource_url: string | null,
  datasource_credentials: DataSourceCredentials
}

export {
  DataSource,
  DataSourceCredentials,
};
