export const env = {
    apiUrl: process.env.NEXT_PUBLIC_API_URL || 'http://localhost:8000/api',
    appUrl: process.env.NEXT_PUBLIC_APP_URL || 'http://localhost:3000',
    environment: process.env.NEXT_PUBLIC_ENVIRONMENT || 'development',
    isDevelopment: process.env.NEXT_PUBLIC_ENVIRONMENT === 'development' || !process.env.NEXT_PUBLIC_ENVIRONMENT,
    isProduction: process.env.NEXT_PUBLIC_ENVIRONMENT === 'production',
} as const;

export type Env = typeof env;