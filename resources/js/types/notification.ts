export type NotificationType = 'info' | 'success' | 'warning' | 'error'

export interface NotificationData {
  title: string
  message: string
  type: NotificationType
  action_url?: string | null
  icon?: string | null
}

export interface UserNotification {
  id: string
  data: NotificationData
  read_at: string | null
  created_at: string
}
